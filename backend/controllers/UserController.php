<?php

namespace backend\controllers;

use Yii;
use common\models\User;
// use backend\models\SignupForm;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\components\GeneralHelpers;
use common\components\PermissionUser;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['check-exists','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'check-exists' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $usersType = array_diff( yii::$app->params['userType']['key'],['developer']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$usersType );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        
        $model = new User();
        $arrImages2 = [];
        $permission = (new PermissionUser('admin'))->listPermission();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if(yii::$app->user->identity->user_type === "developer" && $model->user_type )
                    $model->user_type = $model->user_type;
                else
                    $model->user_type = 'admin_user';

                
                $model->avatar = UploadedFile::getInstance($model, 'avatar');
                                            
                if($model->avatar){     
                    $newname = time().rand(1000, 9999999);
                    $model->avatar->saveAs(Yii::getAlias("@upload/user/").$newname . '.'. $model->avatar->extension);
                    $model->avatar = $newname.'.'.$model->avatar->extension;           
                }

                \backend\models\Signup::signup($model,$model->user_type);
                GeneralHelpers::setImages($model);
                
                Yii::$app->session->setFlash('success', Yii::t('app','New manager signed up successfully.'));
                return $this->redirect(['index']);      
        }

        return $this->render('create', [
            'arrImages2' => $arrImages2,
            'model' => $model,
            'permission' => $permission,

        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $arrImages2 = GeneralHelpers::updateImages($model);

        $model->access = PermissionUser::getPermissionsByUser($id);
        $permission = (new PermissionUser('admin'))->listPermission();

        $statusOld=$model->status;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->avatar = UploadedFile::getInstance($model, 'avatar'); 
            \common\components\MultiUserType::addUserType($model);
            if(!empty($model->password)){
                 $model->setPassword($model->password);
            }

            $model->status=$statusOld;

            if($model->avatar){     
                $newname = time().rand(1000, 9999999);
                $model->avatar->saveAs(Yii::getAlias("@upload/user/").$newname . '.'. $model->avatar->extension);
                $model->avatar = $newname.'.'.$model->avatar->extension;
            }else {
                $model->avatar = $this->findModel($id)->avatar;
            }

            $model->save(false);
            $assign = PermissionUser::assignToUser($model);
            
            GeneralHelpers::setImages($model);
            
            Yii::$app->session->setFlash('success', Yii::t('app','Updates are done successfully.'));
            return $this->redirect(['index']);


        } else {
            return $this->render('/user/update', [
                'model' => $model,
                'permission' => $permission,
                'arrImages2' => $arrImages2,

            ]);
        }
    }
    /**
    *report users
    *
    **/

    public function actionReport()
    {
        $searchModel = new ReportUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('report-user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile()
    {
        $model = $this->findModel(yii::$app->user->identity->id) ;

        $statusOld=$model->status;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->avatar = UploadedFile::getInstance($model, 'avatar'); 

            if(!empty($model->password)){
                 $model->setPassword($model->password);
            }

            $model->status=$statusOld;

            if($model->avatar){     
                $newname = time().rand(1000, 9999999);
                $model->avatar->saveAs(Yii::getAlias("@upload/user/").$newname . '.'. $model->avatar->extension);
                $model->avatar = $newname.'.'.$model->avatar->extension;
            }else {
                    $model->avatar = $this->findModel($model->id)->avatar;
            }

            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::t('app','Updates are done successfully.'));
            return $this->redirect(['profile']);

        } else {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
    }

    public function actionCheckExists()
    {
        $request = Yii::$app->request;
        $identity_id = $request->post('identity_id','');
        $user_type = $request->post('userType','');

        $user = User::find()->where(['identity_id' => $identity_id])->One();

        if(isset($user->{$user_type}))
            $user->{$user_type} = 1;

        if($user){
            $statusAction = \common\components\MultiUserType::addUserType($user);
            $estateOfficeId = GeneralHelpers::getEstateOfficeId();
            if($estateOfficeId){
                switch ($user_type) {
                    case 'renter':
                        $user_estate_office = new \common\models\EstateOfficeRenter();
                        $user_estate_office->renter_id = $user->id;
                        $user_estate_office->estate_office_id = $estateOfficeId;
                        $user_estate_office->save();
                        break;
                     case 'owner':
                        $user_estate_office = new \common\models\EstateOfficeOwner();
                        $user_estate_office->owner_id = $user->id;
                        $user_estate_office->estate_office_id = $estateOfficeId;
                        $user_estate_office->save();
                        break;
                    default:
                        break;
                }
            }
            $statusAction['message'] = $statusAction['message']? : yii::t('app','Updates are done successfully.');
            $user->save(false);
        }else{
            $statusAction =  ['error'=>true , 'message' => yii::t('app','This user does not exist.')];
        }

        if($request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'error'=>$statusAction['error'],
                    'title'=> yii::t('app',"Check or Add"),
                    'content'=>$statusAction['message'],
                    'footer'=> Html::button(yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]),

                ];         
        }else{
            // return $request;
            Yii::$app->session->setFlash($statusAction['error']? 'danger' :'success', $statusAction['message']);
            return $this->redirect(['create']);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // public function upload($newname)
    // {
    //     $user = new User();
    //     if ($this->validate()) {
    //          $this->avatar->saveAs(Yii::getAlias("@toadmin/uploads/user/{$newname}.{$this->avatar->extension}"));
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
/*
    *
    */

    public function actionDeleteFile($id , $attribute="avatar")
    {        
        return GeneralHelpers::deleteImages(User::class,$id ,$attribute);
    }
    
}
