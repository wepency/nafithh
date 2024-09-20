<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\IdentityType;
use common\models\SettingEstateOffice;
use common\models\EstateOffice;
use common\models\UserEstateOffice;
use common\models\EstateOfficeSearch;
use common\models\EstateOfficeOwner;
use common\components\GeneralHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EstateOfficeController implements the CRUD actions for EstateOffice model.
 */
class EstateOfficeController extends Controller
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
                    'force-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EstateOffice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstateOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstateOffice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    } 

    public function actionDeleteFile($id , $attribute="logo")
    {        
        return GeneralHelpers::deleteImages(EstateOffice::class,$id ,$attribute);

    }

    /**
     * Creates a new EstateOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EstateOffice();
		$model->scenario = 'create';
		$arrImages2 = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->asOwnerEstate){
    			$user = \backend\models\Signup::signupOffice($model,'owner_estate_officer');
            }else{
                $user = \backend\models\Signup::signupOffice($model,'estate_officer');
            }
            $user->refresh();
            $model->admin_id = $user->id ;
            $model->save(false);
            $this->setDefaultSetting($model);
			GeneralHelpers::setImages($model);
			
			return $this->redirect(['view', 'id' => $model->id]);
						
        } else {
            return $this->render('create', [
                'model' => $model,
				'arrImages2' => $arrImages2,
            ]);
        }
    }

    public static function setDefaultSetting(&$model){

        // user Estate Office
        $user_office = new UserEstateOffice();
        $user_office->user_id = $model->admin->id;
        $user_office->estate_office_id = $model->id;
        $user_office->save();

        // Setting Estate Office cities and rent_period ..etc
        $settingOffice = new \common\models\SettingEstateOffice();
        $settingOffice->estate_office_id = $model->id;
        $attrWithClass=[
            'citys'=>\common\models\City::class,
            'nationalities'=>\common\models\Nationality::class,
            'identities'=>\common\models\IdentityType::class,
            'building_types'=>\common\models\BuildingType::class,
            // 'housing_unit_types'=>\common\models\HousingUnitType::class,
            'housing_using_types'=> \common\models\HousingUsingType::class,
            'rent_period'=>\common\models\RentPeriod::class,
        ];
        foreach ($attrWithClass as $attr => $class) {
            $listIds = ArrayHelper::map($class::find()->all(),'id','id');
            if($listIds && count($listIds) > 0){
                $settingOffice->$attr = implode(",",($listIds)? : []);
            }
        }
        $settingOffice->save();


        // Setting  Estate Office Payment Method 
        $listSetting = \common\components\GeneralHelpers::getAvailablePaymentMethod();
        foreach ($listSetting as $key => $value) {
            $model->{$value} = 1;
        }


        // Setting  Estate Office default  contract and expire_date balance
        $siteSetting = yii::$app->SiteSetting->info();
        if($siteSetting->contract_default_type === 1){
            $model->contract_default_type = 1;
        }else{
            $peroidDay = $siteSetting->contract_default_period;
            $afterNow = strtotime("+$peroidDay days");
            $model->contract_expire_date = Yii::$app->formatter->asDate($afterNow,'php:Y-m-d');
            $model->expire_date = Yii::$app->formatter->asDate($afterNow,'php:Y-m-d');
            $model->contract_balance = $siteSetting->contract_default_no;
        }


        // Setting  Estate Office default  sms and expire_date balance
        if($siteSetting->sms_default_type === 1){
            $model->sms_default_type = 1;
        }else{
            $peroidDay = $siteSetting->sms_default_period;
            $afterNow = strtotime("+$peroidDay days");
            $model->sms_expire_date = Yii::$app->formatter->asDate($afterNow,'php:Y-m-d');
            $model->sms_balance = $siteSetting->sms_default_no;
        }


        // add user to owner table if user type is owner_estate_officer
        if($model->admin->user_type === 'owner_estate_officer'){
            $estate_office_owner = new EstateOfficeOwner();
            $estate_office_owner->owner_id = $model->admin->id;
            $estate_office_owner->estate_office_id = $model->id;
            $estate_office_owner->save();
        }

        $model->save(false);
    }

    /**
     * Updates an existing EstateOffice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing EstateOffice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        return $id;
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionForceDelete()
    {
        $id = Yii::$app->request->post('id');
        return $this->asJson(['success' => $this->findModel($id)->terminateOfficeAccount()]);
    }


    //  public function actionDeleteAll($id)
    // {
    //     foreach (['580311910','508228573','559454937','503184384','508228571','599343616','544557694','547404366','566199955','534803060','534803061','592135648','535795019','555565111','569450469','532888035'] as $key => $value) {
    //          if (($model = EstateOffice::find()->where(['mobile'=>$value])->one()) !== null) {
    //             $model->deleteWithItems();
    //         } 
    //     }
    //     // http://localhost/aqar/admin/estate-office/delete-all?id=37
    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the EstateOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EstateOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstateOffice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
