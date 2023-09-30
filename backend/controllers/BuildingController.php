<?php

namespace backend\controllers;

use Yii;
use common\models\Building;
use common\models\BuildingSearch;
use common\models\BuildingHousingUnit;
use common\models\EstateOfficeBuilding;
use common\models\EstateOfficeOwner;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use common\components\GeneralHelpers;
use yii\filters\AccessControl;


/**
 * BuildingController implements the CRUD actions for Building model.
 */
class BuildingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view', 'update', 'create'],
                'rules' => [
                    [
                        'actions' => ['view','update', 'create'],
                        'allow' => true,
                        'roles' => ['owner','estate_officer','estate_officer_user','admin','admin_user','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['building' => $this->findModel(Yii::$app->request->get('id'))];
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
     * Lists all Building models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuildingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Building model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      
        
      
        
        // $query = Building::find()->where(['id'=>$id])->orderby('id DESC');
      
        // $customer = Building::find()->where(['id' => $id])->one();
      
        // $offertype   = $customer->offertype;
        // $offerprice  = $customer->offerprice;
        
        // //print_r($customer);
      
        // $customer = Building::findOne($id);
        // if($offertype == 1)
        // {
        //   $customer->for_rent = '0'; 
        //   $customer->rent_price = '0';
        //   $customer->for_sale = '1';
        //   $customer->sale_price = $offerprice;
          
        //   $customer->save();
        // }
        // else
        // {
        //   $customer->for_rent = '1';
        //   $customer->for_sale = '0'; 
        //   $customer->sale_price = '0';
        //   $customer->rent_price = $offerprice;
          
        //   $customer->save(); 
        // }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Building model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($owner_id = null)
    {
        $modelsHousings = [new BuildingHousingUnit];
        $arrImages2 = [];
        $model = new Building();
         // $model->scenario = 'create';

        $model->owner_id = $owner_id;
        if ($model->load(Yii::$app->request->post())) {
            $valid = $model->validate();

            $modelsHousings = Model::createMultiple(BuildingHousingUnit::class);
            Model::loadMultiple($modelsHousings, Yii::$app->request->post());
            $valid = Model::validateMultiple($modelsHousings) && $valid;

            
          
            if ($valid) {
                $model->save();

                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                
                $estate_office_owner = new EstateOfficeOwner();
                $estate_office_owner->owner_id = $model->owner_id;
                $estate_office_owner->estate_office_id = $estate_office_id;
                $estate_office_owner->save();

                $estate_building = new EstateOfficeBuilding();
            
                $estate_building->building_id = $model->id;
                $estate_building->owner_id = $model->owner_id;
                $estate_building->estate_office_id = $estate_office_id;
                $estate_building->user_id = Yii::$app->user->identity->id;
                $estate_building->receive_date = $model->receive_date;
                $estate_building->expire_date = $model->expire_date;
                $estate_building->is_active = 1;
              
                
               
                
                $estate_building->save();
				GeneralHelpers::setImagesWithWatemark($model);
                
                $model->trigger(Building::EVENT_NEW); 
                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = ($model->id!=NULL) ) {
                            foreach ($modelsHousings as $modelHousing) 
                            {
                                $modelHousing->building_id = $model->id;
                                if (! ($flag = $modelHousing->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $modelHousing->trigger(BuildingHousingUnit::EVENT_NEW); 

                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }

            }else{
                return $this->render('create', [
                    'model' => $model,
                    'arrImages2' => $arrImages2,
                    'modelsHousings' => (empty($modelsHousings)) ? [new BuildingHousingUnit] : $modelsHousings,
                ]);
            }
			
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'arrImages2' => $arrImages2,
                'modelsHousings' => (empty($modelsHousings)) ? [new BuildingHousingUnit] : $modelsHousings,
            ]);
        }
    }

    /**
     * Updates an existing Building model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$arrImages2 = GeneralHelpers::updateImages($model);
        $modelsHousings = BuildingHousingUnit::find()->where(['building_id'=>$model->id])->all();

        if ($model->load(Yii::$app->request->post()) ) {
            $valid = $model->validate();

            /**************** PollAnswer *********************/
            $oldIDsUpsell = ArrayHelper::map($modelsHousings, 'id', 'id');
            $modelsHousings = Model::createMultiple(BuildingHousingUnit::class, $modelsHousings);
            Model::loadMultiple($modelsHousings, Yii::$app->request->post());
            $deletedIDsUpsell = array_diff($oldIDsUpsell, array_filter(ArrayHelper::map($modelsHousings, 'id', 'id')));
            $valid = Model::validateMultiple($modelsHousings) && $valid;

            if ($valid) {
                $model->trigger(Building::EVENT_VIEW_RENTER_PAY); 
                $model->save();
                
                GeneralHelpers::setImagesWithWatemark($model);
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $estate_building = EstateOfficeBuilding::find()->where(['estate_office_id'=>$estate_office_id,'building_id'=>$model->id,'is_active'=>1])->one();
                if ($estate_building!==null){
                    $estate_building->receive_date = $model->receive_date;
                    $estate_building->expire_date = $model->expire_date;
                    $estate_building->save();
                }

                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = ($model->id!=NULL)) {
                            if (! empty($deletedIDsUpsell)) {
                                BuildingHousingUnit::deleteAll(['id' => $deletedIDsUpsell]);
                              }
                            foreach ($modelsHousings as $modelHousing) 
                            {
                                $modelHousing->building_id = $model->id;
                                if (! ($flag = $modelHousing->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        
        }
            return $this->render('update', [
                'model' => $model,
                'arrImages2' => $arrImages2,
                'modelsHousings' => (empty($modelsHousings)) ? [new BuildingHousingUnit] : $modelsHousings,

            ]);
    }
    /**
     * Deletes an existing Building model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Building model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Building the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Building::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
