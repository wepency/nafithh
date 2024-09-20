<?php

namespace backend\controllers;

use Yii;
use common\models\InstallmentReceiptCatch;
use common\models\Installment;
use common\models\InstallmentSearch;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use common\models\Model;
use common\components\GeneralHelpers;


/**
 * InstallmentController implements the CRUD actions for Installment model.
 */
class InstallmentController extends Controller
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
                        'roles' => ['estate_officer','estate_officer_user','renter','admin','admin_user','owner','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['installment' => Installment::findOne(Yii::$app->request->get('id'))];
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
     * Lists all Installment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstallmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerateInstallment($contract_id)
    {
        $models = Installment::find()->where(['contract_id'=>$contract_id])->all();
        if (Yii::$app->request->post()) {
            Model::loadMultiple($models, Yii::$app->request->post());
            $valid = Model::validateMultiple($models);

            if ($valid) {
                foreach ($models as $model) 
                {
                    $model->save(false);
                }
                return $this->redirect(['/contract/view', 'id' => $contract_id]);
            }
        
        }
        return $this->render('generate-installment', [
            'models' => (empty($models)) ? [new Installment] : $models,
            'contract_id' => $contract_id,
        ]);
    }

    /**
     * Displays a single Installment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Installment #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])/*.
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])*/
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Updates an existing Installment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->payment_status === Installment::STATUS_CANCEL){
            Yii::$app->session->setFlash('danger',yii::t('app',"This Installment is Cancelled"));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


     public function actionDownload($id,$type = null)
    {
        $model = $this->findModel($id);
        $content = Yii::$app->request->post('image','');
        $title =  Yii::t('app', 'Installment') . ' '.$model->installment_no;
        return \backend\controllers\InstallmentController::down($content,$title);
    }

    /**
     * Deletes an existing Installment model.
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
     * Finds the Installment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Installment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Installment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    protected function findReceiptCatchModel($id)
    {

        if (($model = InstallmentReceiptCatch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public static function down($content,$title)
    {
    //    
        $content = "<img src='". $content."' >";

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' =>  'UTF-8', 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            'marginTop' => 2, 
            'marginBottom' => 2, 
            'marginHeader' => 2, 
            'marginFooter' => 2, 
            'marginLeft' => 2, 
            'marginRight' => 2, 
            // your html content input
            'content' => $content,  
            'filename' => $title.".pdf",  
           
            //  // set mPDF properties on the fly
            'options' => ['title' => $title],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>, 
            //     'SetFooter'=>,
            //     // 'SetFooter'=>['{PAGENO}'],
            // ]
            // 'methods' => [
            //         'SetHeader'=>$header, 
            //         'SetFooter'=>$footer,
            //     ]
        ]);
    
        // return the pdf output as per the destination setting
        return $pdf->render(); 
       
    }
}
