<?php

namespace backend\controllers;

use Yii;
use common\models\MaintenanceOffice;
use common\models\UserMaintenanceOffice;
use common\models\MaintenanceOfficeSearch;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\GeneralHelpers;

/**
 * MaintenanceOfficeController implements the CRUD actions for MaintenanceOffice model.
 */
class SettingMaintenanceOfficeController extends Controller
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
    // public function actionIndex()
    // {
    //     $searchModel = new MaintenanceOfficeSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single MaintenanceOffice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new MaintenanceOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new MaintenanceOffice();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing MaintenanceOffice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
        $model = $this->findModel();
        $arrImages2 = GeneralHelpers::updateImages($model);
        $user = $model->admin;
        $model->_username = $user->username;
        $model->_nationality_id = $user->nationality_id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GeneralHelpers::setImages($model);
            
             if ($model->_password!=''){
                $user->setPassword($model->_password);
                $user->save();
            }

            Yii::$app->session->setFlash('success',Yii::t('app','Updates are done successfully.'));
            return $this->redirect(['index', 
            'model' => $model,
            'arrImages2' => $arrImages2,

            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'arrImages2' => $arrImages2,

        ]);
    }

    public function actionDeleteFile($id , $attribute="logo")
    {        
        return GeneralHelpers::deleteImages(MaintenanceOffice::class,$id ,$attribute);

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
     * Deletes an existing MaintenanceOffice model.
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
     * Finds the MaintenanceOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaintenanceOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel()
    // {
    //     $session = Yii::$app->session;
    //     $id = GeneralHelpers::getMaintenanceOfficeId();

    //     if (($model = MaintenanceOffice::findOne(['estate_office_id' => $id])) !== null) {
    //         $MaintenanceOffice = new MaintenanceOffice();
    //         $MaintenanceOffice->estate_office_id = $model->id;
    //         $MaintenanceOffice->save();
    //         return $model;
    //     }else{
    //         $MaintenanceOffice = new MaintenanceOffice();
    //         $MaintenanceOffice->estate_office_id = $id;
    //         $MaintenanceOffice->save();
    //         return MaintenanceOffice::findOne($id);

    //     }

    //     throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    // }

    protected function findModel()
    {
        $session = Yii::$app->session;
        $id = GeneralHelpers::getMaintenanceOfficeId();

        if ( ($model = MaintenanceOffice::findOne( $id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
