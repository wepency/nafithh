<?php

namespace backend\controllers;

use Yii;
use common\models\Installment;
use common\models\InstallmentReceiptCatch;
use common\models\InstallmentReceiptCatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use mikehaertl\wkhtmlto\Pdf;
use kartik\mpdf\Pdf;
// use kartik\base\Config;
use common\components\GeneralHelpers;


/**
 * InstallmentReceiptCatchController implements the CRUD actions for InstallmentReceiptCatch model.
 */
class InstallmentReceiptCatchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'cancel' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all InstallmentReceiptCatch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstallmentReceiptCatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstallmentReceiptCatch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InstallmentReceiptCatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($installment_id)
    {
        $model = new InstallmentReceiptCatch();

        $installment = $this->findInstallment($installment_id);
        $estatOffice = $installment->contract->estateOffice;

        $messageError = '';
        if($installment->isPaid()){
            $messageError = yii::t('app',"This Installment was paid!");
        }elseIf($installment->isCancelled()){
            $messageError = yii::t('app',"This Installment is Cancelled!");
        }elseIf(!$estatOffice->getListAvailablePaymentMethod() ){
            $messageError = yii::t('app',"The Current Estate Office don't have Any payemnt methode!");
        }elseIf(yii::$app->user->identity->role == 'renter' &&  $estatOffice->enable_installment_deposit_bank == 0){
            $messageError = yii::t('app',"The Current Estate Office don't have Any payemnt methode!");
        }else{

        }

        if($messageError){
            Yii::$app->session->setFlash('danger',$messageError);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->installment_id = $installment->id;
        $model->amount_paid = $installment->amount - $installment->amount_paid;
        $arrImages2 = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(yii::$app->user->identity->role == 'renter'){
                $model->payment_status = Installment::STATUS_UNPAID;
                $model->save(false);
                GeneralHelpers::setImages($model);
                // $model->trigger(InstallmentReceiptCatch::EVENT_PAID);
                return $this->redirect(['index']);
            }

            $installment->amount_paid +=  $model->amount_paid;
            $installment->amount_remaining = $installment->amount - $installment->amount_paid;
            $model->amount_remaining = $installment->amount_remaining;

            //تغيير حالة الدفع بحسب مبلغ الدفع
            if($model->amount_remaining == 0 && $installment->amount_paid >=  $installment->amount){
                $installment->payment_status = $model->payment_status = Installment::STATUS_PAID;

                $installment->trigger(Installment::EVENT_STATEMENT);

            }else{
                $installment->payment_status = $model->payment_status = Installment::STATUS_PART_PAID;
            }
            $model->user_receive_id = Yii::$app->user->identity->id;
            $model->save();
            // $model->trigger(InstallmentReceiptCatch::EVENT_PAID);
            $installment->save();
            GeneralHelpers::setImages($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'arrImages2' => $arrImages2,
            'estatOffice' => $estatOffice,
        ]);

    }

    /**
     * Updates an existing InstallmentReceiptCatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $arrImages2 = GeneralHelpers::updateImages($model);
        if($model->payment_status === Installment::STATUS_CANCEL){
            Yii::$app->session->setFlash('danger',yii::t('app',"This Receipt Catch is Cancelled"));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $installment = $model->installment;

            $installment->amount_paid +=  $model->amount_paid;
            $installment->amount_remaining = $installment->amount - $installment->amount_paid;
            $model->amount_remaining = $installment->amount_remaining;

            //تغيير حالة الدفع بحسب مبلغ الدفع
            if($model->amount_remaining == 0 && $installment->amount_paid >=  $installment->amount){
                $installment->payment_status = $model->payment_status = Installment::STATUS_PAID;
            }else{
                $installment->payment_status = $model->payment_status = Installment::STATUS_PART_PAID;
            }
            $model->user_receive_id = Yii::$app->user->identity->id;
            $model->save();
            // $model->trigger(InstallmentReceiptCatch::EVENT_PAID);
            $installment->save();
            GeneralHelpers::setImages($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $estatOffice = $model->installment->contract->estateOffice;

        return $this->render('update',[
            'model' => $model,
            'estatOffice' => $estatOffice,
            'arrImages2' => $arrImages2,
        ]);
    }

    public function actionDownload($id,$type = null)
    {
        $model = $this->findModel($id);
        $content = Yii::$app->request->post('image','');
        $title = Yii::t('app', 'Receipt Catch') . ' '.$model->receipt_catch_no;
        return \backend\controllers\InstallmentController::down($content,$title);
    }



    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        if($model->payment_status === Installment::STATUS_CANCEL){
            Yii::$app->session->setFlash('danger',yii::t('app',"This Receipt Catch is Cancelled"));
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->payment_status = Installment::STATUS_CANCEL;
        $model->save();

        $installment = $model->installment;
        $installment->amount_paid -=  $model->amount_paid;
        $installment->amount_remaining = $installment->amount - $installment->amount_paid;

        if($installment->amount_remaining === $installment->amount){
            $installment->payment_status = Installment::STATUS_UNPAID;
        }else{
            $installment->payment_status = Installment::STATUS_PART_PAID;
        }

        $installment->save();
        Yii::$app->session->setFlash('success',Yii::t('app','The Receipt Catch has been successfully cancelled'));
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing InstallmentReceiptCatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the InstallmentReceiptCatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstallmentReceiptCatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstallmentReceiptCatch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findInstallment($id)
    {
        if (($model = Installment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
