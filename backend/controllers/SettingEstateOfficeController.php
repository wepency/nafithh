<?php

namespace backend\controllers;

use Yii;
use common\models\UserEstateOffice;
use common\models\User;
use common\models\EstateOffice;
use common\models\SettingEstateOffice;
use common\models\SettingEstateOfficeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\GeneralHelpers;

/**
 * SettingEstateOfficeController implements the CRUD actions for SettingEstateOffice model.
 */
class SettingEstateOfficeController extends Controller
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
     * Lists all SettingEstateOffice models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new SettingEstateOfficeSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single SettingEstateOffice model.
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
     * Creates a new SettingEstateOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new SettingEstateOffice();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing SettingEstateOffice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
        $modelSetting = $this->findModel();
        $model = $this->findModelEstate();
        $arrImages2 = GeneralHelpers::updateImages($model);
        $user = $model->admin;
        $model->_username = $user->username;
        $model->_nationality_id = $user->nationality_id;

        if ($model->load(Yii::$app->request->post()) && $model->save() && $modelSetting->load(Yii::$app->request->post()) && $modelSetting->validate()) {
            GeneralHelpers::setImages($model);

            if ($model->_password!=''){
                $user->setPassword($model->_password);
                $user->save();
            }
            
			$modelSetting->citys = implode(",",($modelSetting->citys) ? $modelSetting->citys : []);
			$modelSetting->nationalities = implode(",",($modelSetting->nationalities) ? $modelSetting->nationalities : []);
			$modelSetting->identities = implode(",",($modelSetting->identities) ? $modelSetting->identities : []);
			$modelSetting->building_types = implode(",",($modelSetting->building_types) ? $modelSetting->building_types : []);
			// $modelSetting->housing_unit_types = implode(",",($modelSetting->housing_unit_types) ? $modelSetting->housing_unit_types : []);
			$modelSetting->housing_using_types = implode(",",($modelSetting->housing_using_types) ? $modelSetting->housing_using_types : []);
			$modelSetting->rent_period = implode(",",($modelSetting->rent_period) ? $modelSetting->rent_period : []);
			$modelSetting->save();
			

            Yii::$app->session->setFlash('success',Yii::t('app','Updates are done successfully.'));
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
            'modelSetting' => $modelSetting,
            'arrImages2' => $arrImages2,

        ]);
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
     * Deletes an existing SettingEstateOffice model.
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
    public function actionDeleteFile($id , $attribute="logo")
    {        
        return GeneralHelpers::deleteImages(EstateOffice::class,$id ,$attribute);

    }

    /**
     * Finds the SettingEstateOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingEstateOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        $session = Yii::$app->session;
        $id = GeneralHelpers::getEstateOfficeId();

        if (($model = SettingEstateOffice::findOne(['estate_office_id' => $id])) !== null) {
            return $model;
        }else{
            $settingEstateOffice = new SettingEstateOffice();
            $settingEstateOffice->estate_office_id = $id;
            $settingEstateOffice->save();
            return SettingEstateOffice::findOne(['estate_office_id' => $id]);

        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findModelEstate()
    {
        $session = Yii::$app->session;
        $id = GeneralHelpers::getEstateOfficeId();

        if ( ($model = EstateOffice::findOne( $id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
