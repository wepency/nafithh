<?php

namespace backend\controllers;

use Yii;
// use common\models\Owner;
use common\models\UserSearch;
use common\models\User;
use common\components\GeneralHelpers;

use backend\controllers\UserController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EstateOfficeOwner;

/**
 * OwnerController implements the CRUD actions for Owner model.
 */
class OwnerController extends UserController
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'owner');

        $user = yii::$app->user->identity;
        switch ($user->role) {
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $dataProvider->query->andFilterWhere(['estate_office_id' => $estate_office_id])
                        ->leftJoin('estate_office_owner', 'user.id = estate_office_owner.owner_id');
                break;
            default:
                # code...
                break;
        }

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
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new Owner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $arrImages2 = [];
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            \backend\models\Signup::signup($model,'owner');
            
            GeneralHelpers::setImages($model);

            Yii::$app->session->setFlash('success', Yii::t('app','New Owner Add successfully.'));

            return $this->redirect(['create']); 
        } else {
            return $this->render('create', [
                'model' => $model,
                'arrImages2' => $arrImages2,
                
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save(false);
                Yii::$app->session->setFlash('success',Yii::t('app','Updates are done successfully.'));
                return $this->redirect(['index']);

        } else {
            return $this->render('/user/_update_contact', [
                'model' => $model,
            ]);
        }

    }


    protected function findModel($id)
    {
        if(in_array(yii::$app->user->identity->role, ['admin','developer'])){
            $model = User::find()->where(['id'=>$id])->one();
        }else{
            $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
            $model = User::find()->leftJoin('estate_office_owner', 'user.id = estate_office_owner.owner_id')->where(['estate_office_owner.estate_office_id'=>$estate_office_id,'id'=>$id])->one();
        }

        if ($model !== null) {
            return $model;
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Owner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Deletes an existing Owner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Owner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Owner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = Owner::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }
}
