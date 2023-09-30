<?php
namespace frontend\models;
use common\models\User;
use yii\base\Model;
use common\components\MultiUserType;
use common\components\GeneralHelpers;

use Yii;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $id;
    // public $username;
    public $email;
    public $mobile;
    public $password;
    public $newPasswordConfirm;
    public $identity_id;
    public $identity_type_id;
    public $avatar;
    public $user_type;
    public $verifyCode;
    public $compony_name;
    public $imageFiles;
    public $nationality_id;


    public static function tableName()
    {
        return 'user';
    }


    // public function formName()
    // {
    //     return 'user';
    // }

    public function  behaviors() 
    { 
        return[
                'uploadBehavior' => [ 
                    'class' => \common\behaviors\UploadBehavior::class,
                        'fileAttribute' => 'avatar',
                        'saveDir' => Yii::getAlias("upload/user/")
                    ], 
             ]; 
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['user_type','name','identity_id'], 'required'],

            // ['username', 'trim'],
            // ['username', 'required'],
            // ['username', 'unique', 'targetClass' => 'common\models\User', 'message' => Yii::t('app','This username has already been taken.')],
            // ['username', 'string', 'min' => 2, 'max' => 255],
            [['compony_name'], 'required', 'when' => function($model) {
                return in_array($model->user_type, ['maintenance_officer','estate_officer']);
            }, 'whenClient' => "function (attribute, value) {
                value = $('#signupform-user_type').find(':checked').val();
                return (value == 'maintenance_officer' || value == 'estate_officer' );
            }"/*, 'message' => yii::t('app','You must select a Housing unit and Maintenance Office')*/],

            ['email', 'trim'],

            ['user_type', 'in', 'range' => array_diff( yii::$app->params['userType']['key'],['developer','admin','admin_user','estate_officer_user','maintenance_officer_user']),'message'=>yii::t('app','errors in user type')],
            
            // ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'common\models\User', 'message' => Yii::t('app','This email address has already been taken.')],

            ['newPasswordConfirm', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t('app',"Password does not match") ],
            ['newPasswordConfirm', 'required'],

            ['identity_id', 'string', 'min' => 6, 'max' => 50],
            ['identity_id', 'unique','targetClass' => 'common\models\User','message'=>yii::t('app','This Identity Number has already been taken.')],

            [['identity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => 'common\models\IdentityType', 'targetAttribute' => ['identity_type_id' => 'id']],

            ['mobile', 'required'],
            [['mobile'], 'number'],
            ['mobile', 'unique','targetClass' => 'common\models\User','message'=>yii::t('app','This mobile has already been taken.')],
            [['mobile'], 'match', 'pattern' => '/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/' ,'message'=>yii::t('app','5xxxxxxxx')],

            ['name', 'required'],
            ['name', 'string'],

            ['avatar', 'safe'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            // ['verifyCode', 'captcha'],

            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','maxFiles' => 10],

            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' =>'common\models\Nationality', 'targetAttribute' => ['nationality_id' => 'id']],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'name' => Yii::t('app', 'Real Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'newPasswordConfirm' => Yii::t('app', 'New Password Confirm'),
            'user_type' => Yii::t('app', 'User type'),
            'avatar' => Yii::t('app', 'avatar'),
            'compony_name' => Yii::t('app', 'Office Name'),
            'mobile' => Yii::t('app', 'Mobile'),
            'name' => Yii::t('app', 'Name'),
            'user_type' => Yii::t('app', 'User Type'),
            'avatar' => Yii::t('app', 'Avatar'),
            'newPasswordConfirm' => Yii::t('app', 'New Password Confirm'),
            'identity_type_id' => Yii::t('app', 'Identity Type'),
            'identity_id' => Yii::t('app', 'Identity Id'),
            'nationality_id' => Yii::t('app', 'Nationality'),
            'imageFiles' => Yii::t('app', 'Attach Documents'),
           
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */

    public function signup()
    {

        $user = new User();
        $user->attributes = $this->attributes;

        $newUser = \backend\models\Signup::signup($user,$user->user_type,$this->compony_name);
        
        $formName = yii\Helpers\Html::getInputName($this, 'imageFiles');
        GeneralHelpers::setImages($newUser,'attachment','imageFiles',$formName);

        if(in_array($user->user_type,['owner_estate_officer','estate_officer','maintenance_officer'])){
            \backend\models\Signup::createOfficeFromUser($newUser,$newUser->role,$this->compony_name);
        }
        
        return $newUser->save(false) ? $newUser : null;
    }
}   
