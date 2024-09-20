<?php

namespace backend\controllers;

use Yii;
use common\models\UserSearch;
use common\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserMaintenanceOffice;
use common\components\GeneralHelpers;
use common\components\PermissionUser;
/**
 * OwnerController implements the CRUD actions for Owner model.
 */
class UserMaintenanceOfficeController extends Controller
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
        $maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'maintenance_office_user');
        $dataProvider->query->andFilterWhere(['maintenance_office_id' => $maintenance_office_id])
                        ->leftJoin('user_maintenance_office', 'user.id = user_maintenance_office.user_id');

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
        $arrImages2 = [];
        $permission = (new PermissionUser('maintenance_officer'))->listPermission();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this::createMaintenanceOfficeUser($model);
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

    public static function createMaintenanceOfficeUser(&$model)
    {
        \backend\models\Signup::signup($model,'maintenance_officer_user');

        $user_maintenance_office = new UserMaintenanceOffice();
        $user_maintenance_office->user_id = $model->id;
        $user_maintenance_office->maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();
        $user_maintenance_office->save();
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
        $model->user_type = 'maintenance_officer_user';
        $arrImages2 = GeneralHelpers::updateImages($model);

        $model->access = PermissionUser::getPermissionsByUser($id);
        $permission = (new PermissionUser('maintenance_officer'))->listPermission();

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
                'permission' => $permission,
                'arrImages2' => $arrImages2,
                
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
        $maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();

        if (($model = User::find($id)->joinWith('userMaintenanceOffice')->where(['user_maintenance_office.maintenance_office_id'=>$maintenance_office_id,'id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
