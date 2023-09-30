<?php

namespace backend\controllers;

use Yii;
use common\models\BuildingHousingUnit;
use common\models\Building;
use common\models\BuildingHousingUnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\GeneralHelpers;

/**
 * BuildingHousingUnitController implements the CRUD actions for BuildingHousingUnit model.
 */
class BuildingHousingUnitController extends Controller
{

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
                                return ['building' => $this->findModel(Yii::$app->request->get('id'))->building
                                ,'housing' => $this->findModel(Yii::$app->request->get('id'))];
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
     * @inheritdoc
     */

    /**
     * Lists all BuildingHousingUnit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuildingHousingUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BuildingHousingUnit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BuildingHousingUnit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=null ,$building_id = null)
    {
        $arrImages2 = [];

        $model = new BuildingHousingUnit();
        $model->scenario = 'create';
        if ($id!=null){
            $data = BuildingHousingUnit::find()->where(['id'=>$id])->one();
            $model->attributes = $data->attributes;
            $model->status = 0;
        }
        if ($building_id!=null){
            $data = Building::findOne($building_id);
            $model->building_id = isset($data->id)? $data->id : null ;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GeneralHelpers::setImagesWithWatemark($model);
            
            $model->trigger(BuildingHousingUnit::EVENT_NEW); 

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'arrImages2' => $arrImages2,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BuildingHousingUnit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arrImages2 = GeneralHelpers::updateImages($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->trigger(BuildingHousingUnit::EVENT_VIEW_RENTER_PAY); 
                $model->save();
                GeneralHelpers::setImagesWithWatemark($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'arrImages2' => $arrImages2,
                'model' => $model,
            ]);
        }
    }


    public function actionCreateContract($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        unset($session['housing_unit'],$session['owner_identity_id']);
        $session['housing_unit'] = $model->id;
        $session['owner_identity_id'] = $model->building->owner->identity_id;
        $this->redirect(['/contract/create#step-3']);
        // return $this->redirect(['/contract/step','step'=>3]);
    }

    /**
     * Deletes an existing BuildingHousingUnit model.
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
     * Finds the BuildingHousingUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BuildingHousingUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BuildingHousingUnit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
