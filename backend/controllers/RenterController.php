<?php

namespace backend\controllers;

use Yii;
use common\models\Renter;
use common\models\User;
use common\models\UserSearch;
use common\models\RenterSearch;
use yii\web\Controller;
use backend\controllers\UserController;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\EstateOfficeRenter;
use common\components\GeneralHelpers;


/**
 * RenterController implements the CRUD actions for Renter model.
 */
class RenterController extends UserController
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
     * Lists all Renter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'renter');

        $user = yii::$app->user->identity;
        switch ($user->role) {
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $dataProvider->query->andFilterWhere(['estate_office_id' => $estate_office_id])
                        ->leftJoin('estate_office_renter', 'user.id = estate_office_renter.renter_id');
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
     * Displays a single Renter model.
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
     * Creates a new Renter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $arrImages2 = [];
        
        $modelRenter = new Renter();

        if ($model->load(Yii::$app->request->post())  && $modelRenter->load(Yii::$app->request->post()) && $model->validate() && $modelRenter->validate()) {
            \backend\models\Signup::signup($model,'renter');
            GeneralHelpers::setImages($model);

            Yii::$app->session->setFlash('success', Yii::t('app','New Renter Add successfully.'));
            return $this->redirect(['create']);      
        }

        // print_r(Yii::$app->request->post()); die();
        // print_r($modelRenter->getErrors()); die();
        return $this->render('create', [
            'model' => $model,
            'arrImages2' => $arrImages2,
            'modelRenter' => $modelRenter,
        ]);

    }


    /**
     * Updates an existing Renter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

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
            $model = User::find()->leftJoin('estate_office_renter', 'user.id = estate_office_renter.renter_id')->where(['estate_office_renter.estate_office_id'=>$estate_office_id,'id'=>$id])->one();
        }

        if ($model !== null) {
            return $model;
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);
//         $modelRenter = $this->findModelRenter($id);
// // print_r($modelRenter); die();
//         if ($model->load(Yii::$app->request->post()) && $model->validate() && $modelRenter->load(Yii::$app->request->post()) && $modelRenter->validate()) {
//             $statusOld=$model->status;
//             $model->avatar = UploadedFile::getInstance($model, 'avatar'); 

//             if(!empty($model->password)){
//                  $model->setPassword($model->password);
//             }

//             $model->status=$statusOld;

//             if($model->avatar){     
//                 $newname = time().rand(1000, 9999999);
//                 $model->avatar->saveAs(Yii::getAlias("@upload/user/").$newname . '.'. $model->avatar->extension);
//                 $model->avatar = $newname.'.'.$model->avatar->extension;

//                 $model->save(false);
//                 $modelRenter->save(false);

//                 Yii::$app->session->setFlash('success',Yii::t('app','Updates are done successfully.'));
//                 return $this->redirect(['index']);
                   
//             }else {
                
//                     $model->avatar = $this->findModel($id)->avatar;
//                     $model->save(false);
//                     $modelRenter->save(false);
//                     Yii::$app->session->setFlash('success', Yii::t('app','Updates are done successfully.'));
//                     return $this->redirect(['index']);
//             }

//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//                 'modelRenter' => $modelRenter,
//             ]);
//         }

//     }

//     /**
//      * Deletes an existing Renter model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

//     /**
//      * Finds the Renter model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return Renter the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
    

//     protected function findModelRenter($id)
//     {
//         if (($model = Renter::findOne($id)) !== null) {
//             return $model;
//         } else {
//             throw new NotFoundHttpException('The requested page does not exist.');
//         }
//     }
}
