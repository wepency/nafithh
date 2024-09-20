<?php

namespace backend\controllers;

use Yii;
use common\models\OrderMaintenance;
use common\models\BuildingHousingUnit;
use common\models\OrderMaintenanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderInfo;
use common\components\GeneralHelpers;
use yii\filters\AccessControl;


/**
 * OrderMaintenanceController implements the CRUD actions for OrderMaintenance model.
 */
class OrderMaintenanceController extends Controller
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
                        'roles' => ['owner','estate_officer','estate_officer_user','renter','maintenance_officer','maintenance_officer_user','admin','admin_user','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['order-maintenance' => $this->findModel(Yii::$app->request->get('id'))];
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
     * Lists all OrderMaintenance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderMaintenanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderMaintenance model.
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
     * Creates a new OrderMaintenance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    
    // public function actionCreate()
    // {
    //     $model = new OrderMaintenance();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing OrderMaintenance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arrImages2 = GeneralHelpers::updateImages($model);
        // print_r(Yii::$app->request->post()); die();
        // print_r(Yii::$app->request->post()); die();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            GeneralHelpers::setImages($model);
            $status = isset(Yii::$app->request->post()['status'])? Yii::$app->request->post()['status'] : $model->status;
            if($id){
                $this->actionChangeStatus($id,$status);
            }


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'arrImages2' => $arrImages2,

        ]);
    }

    // public function actionAcceptOrder($order_id)
    // {
    //     $model = $this->findModel($order_id);
    //     $model->status_accept = 1;
    //     $model->status = 3;
    //     $model->save();
    //     Yii::$app->session->setFlash('success', Yii::t('app','Accepted Order'));

    //     return $this->render('view', [
    //         'model' => $this->findModel($order_id),
    //     ]);
    // }

    public function actionChangeStatus($order_id,$status )
    {
        $model = $this->findModel($order_id);
        $model->status = $status;

        // إذا قام المكتب بقبول الطلب
        if($model->status_accept === 0 && $status == 3){
            $model->status_accept = 1;
            $model->trigger($model::EVENT_QUOTATION);
        }

        // إذا تم الموافقة على عرض سعر المكتب
        if($status == 5){
            // حذف جميع طلبات الصيانة  لنفس الطلب المرسلة للمكاتب الأخرى
            OrderMaintenance::deleteAll(['AND',['order_info_id'=>$model->orderInfo->id ], ['NOT IN','id' , $model->id ] ]);
            $model->commission_amount = $model->price * ($model->maintenanceOffice->tax/100);
            $model->trigger($model::EVENT_ACCEPT);
        }

        // إذا تم إغلاق الطلب
        if($status == 10){
            $model->trigger($model::EVENT_ORDER_CLOSE);
        }


        //إذا تم إرسال ملاحظات من مكتب الصيانة عند قبول الطلب أو إنتهاء الصيانة
        if($status == 7 || $status == 8 || $status == 3){
            $model->trigger($model::EVENT_ORDER_REPLAY);
        }

        if($status == OrderMaintenance::STATUS_PAIDED){
            $model->payment_at = Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i:s');
        }

        $model->save();
        Yii::$app->session->setFlash('success', Yii::t('app','Accepted Order'));

        return $this->render('view', [
            'model' => $this->findModel($order_id),
        ]);
    }

    /**
     * Deletes an existing OrderMaintenance model.
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
     * Finds the OrderMaintenance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderMaintenance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderMaintenance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    
}
