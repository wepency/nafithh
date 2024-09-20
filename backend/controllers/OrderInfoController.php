<?php

namespace backend\controllers;

use Yii;
use common\models\OrderInfo;
use common\models\OrderInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderMaintenance;
use common\models\MaintenanceOffice;
use common\components\GeneralHelpers;
use common\models\BuildingHousingUnit;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;


/**
 * OrderInfoController implements the CRUD actions for OrderInfo model.
 */
class OrderInfoController extends Controller
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
                        'roles' => ['owner','estate_officer','estate_officer_user','renter','admin','admin_user','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['order-info' => $this->findModel(Yii::$app->request->get('id'))];
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
     * Lists all OrderInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderInfo model.
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
     * Creates a new OrderInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($housing_id = null)
    {
        $houisng = $this->findHousing($housing_id);
        $model = new OrderInfo();
        $model->building_housing_unit_id = $houisng->id;

        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        if(!$houisng->contract && !$estate_office_id){
            Yii::$app->session->setFlash('danger', Yii::t('app','can`t create Order Maintenance,Because This Unit havn`t Contract, or Estate Office' ));
            return $this->redirect('index');
        }

        $model->estate_office_id =  $houisng->contract->estate_office_id ?? $estate_office_id;
        $estateOfficeName = $model->estateOffice->name;

        $arrImages2 = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = Yii::$app->user->identity;
            $model->sender_type = 'estate_officer';
            if(in_array($user->role, ['owner','renter'])){
                $model->sender_id = Yii::$app->user->identity->id;
                $model->sender_type = $user->role;
            }
            
            // $model->estate_office_id =  $houisng->contract->estate_office_id ?? null;

            // إذا كانت مسودة
            if(isset(Yii::$app->request->post()['is_draft']) || $model->send_to == 'estate_officer'){
                $model->is_draft = 1;
                $model->save(false);

                (new OrderInfo)->eventNew($model);

                GeneralHelpers::setImages($model);
                
                if(isset(Yii::$app->request->post()['is_draft']))
                    Yii::$app->session->setFlash('success', Yii::t('app','Order Saved As Draft.'));
                else
                    Yii::$app->session->setFlash('success', Yii::t('app','Order Saved successful.'));

                return $this->redirect(['view', 'id' => $model->id]);
            }

            if($model->save(false) && $this->addOrderMaintenance($model)){
                GeneralHelpers::setImages($model);

                (new OrderInfo)->eventNew($model);

                Yii::$app->session->setFlash('success', Yii::t('app','Order Saved successful.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'arrImages2' => $arrImages2,
            'model' => $model,
            'estateOfficeName' => $estateOfficeName,
        ]);
    }

    public function actionUpdate($id)
    {
        
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $arrImages2 = GeneralHelpers::updateImages($model);
        $estateOfficeName = $model->estateOffice->name;
        
        $orders_ids = ArrayHelper::getColumn($model->orderMaintenances, 'maintenance_office_id');
        $model->maintenanceOffice = $orders_ids;

        if($model->load($request->post()) && $model->validate() ){

            $user = Yii::$app->user->identity;
            $model->sender_type = in_array($user->role, ['estate_officer']) ?  'estate_officer' : $user->role;

            GeneralHelpers::setImages($model);

            // إذا كانت مسودة
            if(isset($request->post()['is_draft']) || $model->send_to == 'estate_officer'){
                $model->is_draft = 1;
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::t('app','Order Saved As Draft.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $model->is_draft = ($model->is_draft === 1)? 0 : $model->is_draft;

            if($model->save(false) && $this->addOrderMaintenance($model)){
                Yii::$app->session->setFlash('success', Yii::t('app','Order Saved successful.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'arrImages2' => $arrImages2,
            'estateOfficeName' => $estateOfficeName,
        ]);  
    }

    // public function actionCreate()
    // {
    //     $model = new OrderInfo();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing OrderInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing OrderInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function addOrderMaintenance($model)
    {
        $MainOffices = $model->maintenanceOffice;
        (bool) $flag = true;
        foreach ($MainOffices as $key => $value) {

            if (($maintenanceOffice = MaintenanceOffice::findOne($value)) !== null) {
                if (OrderMaintenance::find()->where(['maintenance_office_id' => $maintenanceOffice->id,'order_info_id' => $model->id])->one() !== null) {
                    continue;
                }

               $order = new OrderMaintenance; 
               $order->maintenance_office_id = $maintenanceOffice->id ; 
               $order->order_info_id = $model->id; 
               $order->status = 2; 
               $order->price = 0; 
               $flag = $flag && $order->save();
               $order->trigger($order::EVENT_NEW);
            }
        }
        return $flag;
    }

    /**
     * Finds the OrderInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderInfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findHousing($id)
    {
        if (($model = BuildingHousingUnit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The Housing Unit not exist.'));
    }
}
