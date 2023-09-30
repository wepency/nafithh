<?php
namespace backend\models;
use common\models\EstateOffice;
use common\models\UserEstateOffice;
use common\models\MaintenanceOffice;
use common\models\UserMaintenanceOffice;
use common\models\EstateOfficeOwner;
use common\models\User;
use common\models\Renter;
use common\models\EstateOfficeRenter;
use yii\base\Model;

use Yii;


/**
 * Signup form
 */
class Signup extends Model
{
    // public $name;
    // public $username;
    // public $email;
    // public $newPasswordConfirm;
    // public $password;
    // public $avatar;
    // public $user_type;

    public function  behaviors() 
    { 
        return[
                'uploadBehavior' => [ 
                    'class' => \common\behaviors\UploadBehavior::class,
                        'fileAttribute' => 'avatar',
                        'saveDir' => Yii::getAlias("@upload/user/")
                    ], 
             ]; 
    }

   

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */

    public static function signupOffice($office,$user_type)
    {
        $user = new User();
        $user->username = $office->_username;
        $user->nationality_id = $office->_nationality_id;
        $user->password = $office->_password;
        $user->name = $office->name;
        $user->email = $office->email;
        $user->mobile = $office->mobile;
        $user->identity_id = $office->registration_code;
        $userSaved = self::signup($user , $user_type);
        return $userSaved;
    }

    public static function signup(&$model,$user_type,$officeName = null)
    {
        // print_r($user_type); die();   
        $setting = yii::$app->SiteSetting->info();

        $model->password =$model->newPasswordConfirm = $model->password?? rand(100000,999999);

        $model->username = $model->username?? $model->identity_id ;
        $model->identity_type_id = $model->identity_type_id?? (\common\models\IdentityType::find()->one()->id ?? null ) ;
        $model->nationality_id = $model->nationality_id?? (\common\models\Nationality::findOne($setting->default_nationality_id)->id ?? null) ;
        
       
        $model->setPassword($model->password);
        $model->generateAuthKey();
        $model->status = User::STATUS_ACTIVE;
        $model->confirmed = 1;
        $model->user_type = $model->user_type?? $user_type;
        $table = Yii::$app->db->schema->getTableSchema('user');
        if(is_string($model->user_type) && isset($table->columns[$model->user_type])){
            $model->{$model->user_type} = 1;
        }
        
        // die();
 
        $min = pow(10,5);
        $max = pow(10,5+1)-1;
        $value = rand($min, $max);
        $model->activation_code = $value;
        $model->save(false);
        $assign = \common\components\PermissionUser::assignToUser($model);
        $model->trigger(User::EVENT_NEW); 

        self::createRelation($model);

        if($model->user_type == 'renter'){
            $modelRenter = new Renter();
            $modelRenter->load(Yii::$app->request->post());
            $modelRenter->user_id = $model->id;
            $modelRenter->save(false);
            unset($modelRenter);
        }

        return $model;
    }

    public static function createOfficeFromUser($user,$officeType = 'estate_officer',$officeName = null)
    {

        $class = EstateOffice::class;
        $classUser = UserEstateOffice::class;

        if($officeType == 'maintenance_officer'){
            $class = MaintenanceOffice::class;
            $classUser = UserMaintenanceOffice::class;
        }

        // إذا كان المستخدم مسترك بمكتب مسبقاً فلن يتم إضافة مكتب جديد
        if(($classUser::find()->where(['user_id'=> $user->id])->one()) === null){
            $office = new $class();
            $office->name = ($officeName != null)? $officeName : $user->name;
            $office->auth_person = $user->name ;
            $office->registration_code = $user->identity_id ;
            $office->mobile = $user->mobile ;
            $office->email = $user->email ;
            $office->status_account = User::STATUS_ACTIVE ;
            $office->_nationality_id = $user->nationality_id ;
            $office->admin_id = $user->id ;
            $office->user_created_id = Yii::$app->user->identity->id?? null ;
            $office->save(false);
        }

        if($officeType == 'estate_officer'){
            \backend\controllers\EstateOfficeController::setDefaultSetting($office);
        }elseif($officeType == 'maintenance_officer'){
            \backend\controllers\MaintenanceOfficeController::setDefaultSetting($office);
        }

        // add user to owner table if user type is owner_estate_officer
        if($office->admin->user_type === 'owner_estate_officer'){
            $estate_office_owner = new EstateOfficeOwner();
            $estate_office_owner->owner_id = $office->admin->id;
            $estate_office_owner->estate_office_id = $office->id;
            $estate_office_owner->save();
        }
        unset($office);
    }

    public static function createRelation($model)
    {
        $session = Yii::$app->session;
        unset($session['estate_office_id']);
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        if($estate_office_id){
            switch ($model->role) {
            case 'owner':
                $estateOwner = new EstateOfficeOwner();
                $estateOwner->owner_id = $model->id;
                $estateOwner->estate_office_id = $estate_office_id;
                $estateOwner->save();
                break;
            case 'renter':
                $estateRenter = new EstateOfficeRenter();
                $estateRenter->renter_id = $model->id;
                $estateRenter->estate_office_id = $estate_office_id;
                $estateRenter->save();
                break;
            default:
                break;
            }
        }
    }

    

}
