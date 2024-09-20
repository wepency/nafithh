<?php

namespace backend\controllers;

use Yii;
use common\models\UserMaintenanceOffice;
use common\models\MaintenanceOffice;
use common\models\MaintenanceOfficeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\GeneralHelpers;
use common\models\User;
use common\models\IdentityType;

/**
 * MaintenanceOfficeController implements the CRUD actions for MaintenanceOffice model.
 */
class MaintenanceOfficeController extends Controller
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
     * Lists all MaintenanceOffice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaintenanceOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaintenanceOffice model.
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
     * Creates a new MaintenanceOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaintenanceOffice();
        $model->scenario = 'create';
        $arrImages2 = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            \backend\models\Signup::signupOffice($model,'maintenance_officer');
            GeneralHelpers::setImages($model);
            
            return $this->redirect(['view', 'id' => $model->id]);
                        
        } else {
            return $this->render('create', [
                'model' => $model,
                'arrImages2' => $arrImages2,
            ]);
        }
    }

     public static function setDefaultSetting($model){

        $user_office = new UserMaintenanceOffice();
        $user_office->user_id = $model->admin->id;
        $user_office->maintenance_office_id = $model->id;
        $user_office->save();
    }

    /**
     * Updates an existing MaintenanceOffice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arrImages2 = GeneralHelpers::updateImages($model);
        $user = $model->admin;
        
        $model->_username = $user->username;
        $model->_nationality_id = $user->nationality_id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->_password!=''){
                $user->setPassword($model->_password);
            }
            $user->nationality_id = $model->_nationality_id;
            $user->save();
            
            GeneralHelpers::setImages($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'arrImages2' => $arrImages2,
            ]);
        }
    }

    /**
     * Deletes an existing MaintenanceOffice model.
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
     * Finds the MaintenanceOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaintenanceOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaintenanceOffice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
