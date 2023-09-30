<?php

namespace backend\controllers;

use Yii;
use common\models\BuildingHousingUnit;

use common\models\ReceiptVoucher;
use common\models\User;
use common\models\Installment;
use common\models\ReceiptVoucherSearch;
use common\models\EstateOfficeBuilding;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\GeneralHelpers;
use yii\filters\AccessControl;

/**
 * ReceiptVoucherController implements the CRUD actions for ReceiptVoucher model.
 */
class ReceiptVoucherController extends Controller
{
    /**
     * {@inheritdoc}
     */
   public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view','update'],
                'rules' => [
                    [
                        'actions' => ['view','update'],
                        'allow' => true,
                        'roles' => ['owner','estate_officer','estate_officer_user','admin','admin_user','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['receipt-voucher' => $this->findModel(Yii::$app->request->get('id'))];
                        },
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ReceiptVoucher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiptVoucherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReceiptVoucher model.
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
     * Creates a new ReceiptVoucher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $arrImages2 = [];

        $model = new ReceiptVoucher();
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $estatOffice = \common\models\EstateOffice::findOne($estate_office_id);
        $estateHousing = \common\models\BuildingHousingUnit::find()->joinWith(['building','building.estateContract'])->andOnCondition(['estate_office_building.estate_office_id' => $estate_office_id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->trigger(ReceiptVoucher::EVENT_STATEMENT); 
            GeneralHelpers::setImages($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'arrImages2' => $arrImages2,
            'model' => $model,
            'estatOffice' => $estatOffice,
            'estateHousing' => $estateHousing,
        ]);
    }


    public function actionCreateOwner($owner_id,array $housing_ids = [])
    {
        $arrImages2 = [];
        $model = new ReceiptVoucher();

        $user = yii::$app->user->identity;
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $estatOffice = \common\models\EstateOffice::findOne($estate_office_id);

        $officeBuilding = EstateOfficeBuilding::find()->where(['estate_office_id' => $estate_office_id,'owner_id'=>$owner_id,'is_active'=>1])->all();
        if(!in_array($user->role, ['estate_officer','developer']) || $officeBuilding == null || empty($officeBuilding)){
            throw new NotFoundHttpException('The Owner does not exist.');
        }
        // var_dump(array_values($housing_ids)); die();

        $andWhere = [
            'contract.owner_id'=> $owner_id,
            'contract.estate_office_id' => $estate_office_id,
        ];

        $InstallmentPart = Installment::find()
        ->select('sum(installment.amount_remaining_owner) as sum')
        ->joinWith('contract')
        ->where(['installment.payment_status_owner'=>Installment::STATUS_PART_PAID])
        ->andWhere($andWhere)
        ->andwhere(['installment.payment_status' => Installment::STATUS_PAID])
        ->andFilterWhere(['contract.housing_unit_id'=>$housing_ids])
        ->asArray()
        ->one();

        $InstallmentAll = Installment::find()
        ->select('sum(installment.amount) as sum')
        ->joinWith('contract')
        ->where(['installment.payment_status_owner'=>Installment::STATUS_UNPAID])
        ->andwhere(['installment.payment_status' => Installment::STATUS_PAID])
        ->andWhere($andWhere)
        ->andFilterWhere(['contract.housing_unit_id'=>$housing_ids])
        ->asArray()
        ->one();

        $total = ($InstallmentPart['sum']?? 0) + ($InstallmentAll['sum']?? 0);
        // var_dump($total); die();
        $model->estate_office_id = $estate_office_id;
        $model->owner_id = $owner_id;
        $model->recipient_type = 'owner';
            // $model->amount = $total;
        if($model->load(Yii::$app->request->post())){

            if($model->amount > $total){
                Yii::$app->session->setFlash('danger', Yii::t('app','You cannot cash out an amount greater than the total Installments paid to you'));
                return $this->render('create-owner', [
                    'arrImages2' => $arrImages2,
                    'model' => $model,
                    'estatOffice' => $estatOffice,
                ]);
            }

        // var_dump($total); die();
            if ($model->validate()) {
                $model->save();
                $housing_ids_sting = [];

                $Installments = Installment::find()
                ->joinWith('contract')
                ->andFilterWhere(['contract.housing_unit_id'=>$housing_ids])
                ->andwhere(['installment.payment_status' => Installment::STATUS_PAID])
                ->andWhere(['IN','installment.payment_status_owner', [Installment::STATUS_UNPAID,Installment::STATUS_PART_PAID]])
                ->andWhere($andWhere)
                ->orderBy(['amount_remaining_owner'=>SORT_ASC,'id'=>SORT_DESC])
                ->all();
                $amount = $model->amount;
                foreach ($Installments as  $installment) {
                    if($installment->payment_status_owner === Installment::STATUS_PART_PAID){
                        if($amount >= $installment->amount_remaining_owner){
                            $amount2 = $installment->amount_remaining_owner;
                            $installment->payment_status_owner = Installment::STATUS_PAID;
                            $installment->amount_remaining_owner = null;
                        }else{
                            $amount2 = $amount;
                            $installment->amount_remaining_owner -= $amount2;
                        }
                        $amount -= $amount2;
                        $installment->save();
                        $installment->createStatementOwner($amount2,$model->id);
                        if(isset($installment->contract->housing_unit_id)){
                            $housing_ids_sting[$installment->contract->housing_unit_id] = $installment->contract->housing_unit_id;
                        }

                        if($amount <= 0){
                            break;
                        }
                    }elseif($installment->payment_status_owner == Installment::STATUS_UNPAID){
                        if($amount >= $installment->amount){
                            $amount2 = $installment->amount;
                            $installment->payment_status_owner = Installment::STATUS_PAID;
                        }else{
                            $amount2 = $amount;
                            $installment->amount_remaining_owner = $installment->amount - $amount2;
                            $installment->payment_status_owner = Installment::STATUS_PART_PAID;
                        }
                        $amount -= $amount2;
                        $installment->createStatementOwner($amount2,$model->id);

                        $installment->save();
                        if(isset($installment->contract->housing_unit_id)){
                            $housing_ids_sting[$installment->contract->housing_unit_id] = $installment->contract->housing_unit_id;
                        }
                        if($amount <= 0){
                            break;
                        }
                    }else{
                        break;
                    }
                }            

                if(is_array($housing_ids_sting)){
                    $housing_ids_sting = implode(',', $housing_ids_sting);
                    $housing_ids_sting = $model->setDetail('statementOwner',['hounsing_ids'=> $housing_ids_sting]);
                    $model->save(false);
                }

                GeneralHelpers::setImages($model);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $model->amount = $total;

        return $this->render('create-owner', [
            'arrImages2' => $arrImages2,
            'model' => $model,
            'estatOffice' => $estatOffice,
        ]);
    }

    /**
     * Updates an existing ReceiptVoucher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     $arrImages2 = GeneralHelpers::updateImages($model);
    //     $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
    //     $estatOffice = \common\models\EstateOffice::findOne($estate_office_id);
    //     $housing = BuildingHousingUnit::find()->joinWith('building','building.estateContract')->all();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         GeneralHelpers::setImages($model);

    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'arrImages2' => $arrImages2,
    //         'model' => $model,
    //         'estatOffice' => $estatOffice,

    //     ]);
    // }

    /**
     * Deletes an existing ReceiptVoucher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReceiptVoucher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReceiptVoucher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = ReceiptVoucher::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
