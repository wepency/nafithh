<?php

namespace backend\controllers;

use Yii;
use common\models\MaintenanceInvoice;
use common\models\MaintenanceOffice;
use common\models\OrderMaintenance;
use common\models\MaintenanceInvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaintenanceInvoiceController implements the CRUD actions for MaintenanceInvoice model.
 */
class MaintenanceInvoiceController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all MaintenanceInvoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaintenanceInvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaintenanceInvoice model.
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
     * Creates a new MaintenanceInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaintenanceInvoice();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            self::addMaintenanceInvoice($model->maintenanceOffice,$model->date_from,$model->date_to);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MaintenanceInvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MaintenanceInvoice model.
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
     * Finds the MaintenanceInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaintenanceInvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPaid($id)
    {
        $model = $this->findModel($id);
        
        if(yii::$app->user->can('/maintenance-invoice/paid')) {
            $model->payment_status = 1;
            $model->save(false);
            
        }
        return $this->redirect(Yii::$app->request->referrer);

    }

     protected function findModel($id)
    {
        $maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();

        if (isset($maintenance_office_id)){
            $model = MaintenanceInvoice::find()->where(['office_id'=>$maintenance_office_id,'id'=>$id])->one();
        }else{
            $model = MaintenanceInvoice::findOne($id);
        }
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

    }


    public static function addMaintenanceInvoice(array $MainOffices,$date_from = '',$date_to='')
    {   
        // حالات الفاتورة التي سيتم اعتمادها عند احتساب الفاتورة
        $commission_status = array(OrderMaintenance::STATUS_PAIDED);
        // لتحويل مصفوفة حالات الفاتورة إلى نص
        $commission_status= self::getCommissionStatusBased($commission_status);
        $MainOffices= self::getCommissionStatusBased($MainOffices);
        $and_status = '';

        if(1==2){
            // إذا كان  إصدار الفواتير تلقائي كل فترة محددة
           //  $peroidDay = (int) yii::$app->params['peroidMarkterToAgent'];
           // $startDate = Yii::$app->formatter->asDate( date("Y-m-d" , strtotime("-$peroidDay days") )."00:00:00" ,'php:Y-m-d H:i:s');
        }else{
           $date_covered_start = Yii::$app->formatter->asDate( isset($date_from)? $date_from.' 00:00:00' : time(),'php:Y-m-d H:i:s');
        }

        $date_covered_end = Yii::$app->formatter->asDate( isset($date_to)? $date_to.' 23:59:59' : time(),'php:Y-m-d H:i:s');

        $and = " AND payment_at BETWEEN '$date_covered_start' AND '$date_covered_end' ";

        if($commission_status){
            $and_status = " AND status in ($commission_status) ";
        }
        $stmt="
        SELECT id FROM {{maintenance_office}}
        WHERE
        id IN (".$MainOffices.")
        AND
        id NOT IN (
           select office_id from {{maintenance_invoice}}
           where
           date_from = ".yii::$app->db->Schema->quoteValue($date_covered_start)."
           and
           date_to = ".yii::$app->db->Schema->quoteValue($date_covered_end)."
        )";

        if (isset($_GET['debug'])){ dump($stmt); }      

        $result = Yii::$app->db->createCommand($stmt)->queryAll();

        if (is_array($result) && count($result)>=1){

            foreach ($result as $val) {

                if (isset($_GET['debug'])){ dump($val); }

                $stmt2="
                SELECT SUM(price) as total_amount
                FROM {{order_maintenance}}
                WHERE
                maintenance_office_id=".yii::$app->db->Schema->quoteValue($val['id'])."
                $and
                $and_status
                ";

                $result2 = Yii::$app->db->createCommand($stmt2)->queryAll();

                    // print_r($result2); die();
                if (isset($_GET['debug'])){ dump($stmt2); }

                if (is_array($result2) && count($result2)>=1){

                    $maintenanceOffice = MaintenanceOffice::findOne($val['id']);

                    $result2 = $result2[0];
                    $commission_amount = $result2['total_amount'] * ($maintenanceOffice->tax/100); 

                    $invoice  = new MaintenanceInvoice();  
                    $invoice->date_from =   $date_covered_start;    
                    $invoice->maintenanceOffice =   [1];    
                    $invoice->date_to =  $date_covered_end;    
                    $invoice->total_amount =  isset($result2['total_amount'])?$result2['total_amount'] :0 ;     
                    $invoice->commission_percent =  $maintenanceOffice->tax;     
                    $invoice->commission_amount =  $commission_amount;     
                    $invoice->office_earnings =  $result2['total_amount'] - $commission_amount;     
                    $invoice->payment_status =  0 ;    
                    $invoice->office_id =  $val['id'] ;    

                    $invoice->save();
                }
            }
        } else {
            if (isset($_GET['debug'])){ echo "No results";}
        }

    }

    public static function getCommissionStatusBased($status)
    {   
        $_stats = '';
        foreach ($status as $stats) {
            $_stats.="'$stats',";
        }
        $_stats=substr($_stats,0,-1);
        return $_stats;
    }
}
