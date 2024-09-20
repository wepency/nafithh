<?php

namespace backend\controllers;

use Yii;
// use common\models\Owner;
use common\models\UserSearch;
use common\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserEstateOffice;
use common\components\GeneralHelpers;
use common\components\PermissionUser;

/**
 * OwnerController implements the CRUD actions for Owner model.
 */
class UserEstateOfficeController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Owner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'estate_officer_user');
        $dataProvider->query->andFilterWhere(['estate_office_id' => $estate_office_id])
                        ->leftJoin('user_estate_office', 'user.id = user_estate_office.user_id');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Owner model.
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
     * Creates a new Owner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $permission = (new PermissionUser('estate_officer'))->listPermission();
        $arrImages2 = [];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this::createEstateOfficeUser($model);
            GeneralHelpers::setImages($model);

            Yii::$app->session->setFlash('success', Yii::t('app','New User Add successfully.'));
            return $this->redirect(['create']); 
        } else {
            return $this->render('create', [
                'model' => $model,
                'arrImages2' => $arrImages2,
                'permission' => $permission,
            ]);
        }
    }

    public static function createEstateOfficeUser(&$model)
    {
        \backend\models\Signup::signup($model,'estate_officer_user');
        
        $user_estate_office = new UserEstateOffice();
        $user_estate_office->user_id = $model->id;
        $user_estate_office->estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $user_estate_office->save();
    }
    /**
     * Updates an existing Owner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->user_type = 'estate_officer_user';
        $arrImages2 = GeneralHelpers::updateImages($model);
        $model->access = PermissionUser::getPermissionsByUser($id);
        $permission = (new PermissionUser('estate_officer'))->listPermission();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(!empty($model->password)){
                 $model->setPassword($model->password);
            }
            $model->save();
            $assign = PermissionUser::assignToUser($model);

            GeneralHelpers::setImages($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'arrImages2' => $arrImages2,
                'permission' => $permission,
            ]);
        }
    }

    /**
     * Deletes an existing Owner model.
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
     * Finds the Owner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Owner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();

        if (($model = User::find()->joinWith('userEstateOffice')->where(['user_estate_office.estate_office_id'=>$estate_office_id,'id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
