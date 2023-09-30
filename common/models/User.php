<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\components\GeneralHelpers;
use common\components\SiteSetting;
use yii\helpers\Html;



/**
 * User model
 *
 * @property string $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $mobile
 * @property string $name
 * @property string $activation_code
 * @property int $confirmed
 * @property string $user_type
 * @property string $avatar
 * @property string $description
 * @property string $address
 * @property string|null $identity_id 
* @property int $identity_type_id 
* @property int $nationality_id 
* @property int $black_list 
* @property int $fav_lang 
 * @property int $agree_term
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const NOTIF_TEMP_NEW = 13;
    const EVENT_NEW = 'eventNew';

    public function init(){
      $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
      parent::init(); // DON'T Forget to call the parent method.
    }

    public $password;
    public $newPasswordConfirm;
    public $file;
    public $imageFiles;
    public $access;
    
    // public $renter;
    // public $owner;
    // public $estate_officer;
    // public $maintenance_officer;

       public static function tableName()
    {
        return 'user';
    }
   
    public function behaviors()
    {
        return [
            'polymorphic' => [
                'class' => \common\behaviors\RelatedPolymorphicBehavior::class,
                'polyRelations' => [
                    'attachments' => [
                        'type' => \common\behaviors\RelatedPolymorphicBehavior::HAS_MANY,
                        'class' => Attachment::class,
                        'deleteRelated' => true,
                    ],
                ],
                'polymorphicType' => $this->tableName(),
                'pkColumnName' => 'id',
                'foreignKeyColumnName' => 'item_id',
                'typeColumnName' => 'item_type',
            ],
            TimestampBehavior::class,

        ];
    }

   
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['fav_lang', 'default', 'value' => 'ar'],
            ['black_list', 'default', 'value' => 0],
            ['black_list', 'in', 'range' => [0, 1]],

            ['user_type', 'in', 'range' => yii::$app->params['userType']['key'],'message'=>yii::t('app','errors in user type')],
            [[/*'username',*/ 'name','identity_type_id','identity_id','black_list','nationality_id' /*, 'mobile', 'description', 'address'*/], 'required'],
            [['created_at', 'updated_at', 'confirmed','identity_type_id','black_list','nationality_id'], 'integer'],
            [['description'], 'string'],
            [['user_type','fav_lang'], 'string', 'max' => 30],
            [['name', 'email', 'avatar', 'address'], 'string', 'max' => 250],
            
            [['file'], 'file', 'extensions' => 'png, jpg , png'],
            
            [['avatar'], 'safe'],

            [['mobile'], 'number'],
            [['mobile'], 'number'],
            ['mobile', 'unique','message'=>yii::t('app','This mobile has already been taken.')],
            
            ['mobile', 'required'],
            [['mobile'], 'match', 'pattern' => '/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/' ,'message'=>yii::t('app','5xxxxxxxx')],
            
            ['username', 'trim'],
            // ['username', 'required'],
            ['username', 'unique','message'=>yii::t('app','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['identity_id', 'string', 'min' => 6, 'max' => 50],
            ['identity_id', 'unique','message'=>yii::t('app','This Identity Number has already been taken.')],

            [['identity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentityType::class, 'targetAttribute' => ['identity_type_id' => 'id']],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nationality::class, 'targetAttribute' => ['nationality_id' => 'id']],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'unique','message'=>yii::t('app','This email address has already been taken.')],
            
            // [['password'],'required','on'=>'create'],
            ['password', 'string', 'min' => 6],
            // ['newPasswordConfirm', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t('app',"Password does not match") ],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','maxFiles' => 10],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif'],
            [['access'], 'each', 'rule' => ['string'], 'skipOnError' => true],
            [['agree_term'], 'integer'],
            [['renter','owner','estate_officer','maintenance_officer'],'default', 'value' => 0],
            [['renter','owner','estate_officer','maintenance_officer'],'integer'],


            

        ];
    }
     public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'mobile' => Yii::t('app', 'Mobile'),
            'name' => Yii::t('app', 'Name'),
            'activation_code' => Yii::t('app', 'Activation Code'),
            'confirmed' => Yii::t('app', 'Confirmed'),
            'user_type' => Yii::t('app', 'User Type'),
            'avatar' => Yii::t('app', 'Avatar'),
            'description' => Yii::t('app', 'Other Notes'),
            'address' => Yii::t('app', 'Address'),
            'nationality_id' => Yii::t('app', 'Nationality'),
            'newPasswordConfirm' => Yii::t('app', 'New Password Confirm'),
            'agree_term' => Yii::t('app', 'Agree Terms and conditions'),
            'identity_type_id' => Yii::t('app', 'Identity Type'),
            'identity_id' => Yii::t('app', 'Identity Id'),

        ];
    }

    // public function scenarios() 
    // { 
    //    $scenarios = parent::scenarios(); 
    //    $scenarios['create'] = ['username','email','status','created_at','mobile','name','activation_code','confirmed','user_type','avatar','description','address','identity_id ','identity_type_id ','nationality_id ','black_list ','fav_lang ','agree_term']; 
    //    // $scenarios['updateuserorder'] = ['username','email','name','mobile','address','description']; 
    //    return $scenarios; 
    // } 


   public function fields()
    {
        return [
            'user_id'=> function ($model) 
            {
                return $model->id;
            },
            'username',
            'email',
            'mobile',
            'name',
            'status',
            'status_name'=>function ($model) 
            {
                if ($model->status==10)
                    return Yii::t('app', 'Available');
                else
                    return Yii::t('app','Not Available');
            },
            'address',
            'description',
            'avatar'=> function ($model) 
            {
                if(!empty($model->avatar))
                    return Yii::$app->uploadUrl->baseUrl."/user/".$model->avatar;
                else
                    return Yii::$app->uploadUrl->baseUrl."/user/user.png";
            }
        ];    
       
    }

    public function beforeDelete()
    {
        
        if (parent::beforeDelete()) {
            if(!(

                ($this->role === 'estate_officer' &&
                    ($a = EstateOffice::find()->JoinWith('userEstateOffice')->where(['user_estate_office.user_id' => $this->id])->one())
                )
                || ($this->role === 'maintenance_officer' && 
                    ($a = MaintenanceOffice::find()->JoinWith('userMaintenanceOffice')->where(['user_maintenance_office.user_id' => $this->id])->one())
                )
                // owner
                ||($this->role === 'owner' && (
                    ($a = Building::find()->where(['owner_id' => $this->id])->one())
                    || ($a = Contract::find()->where(['owner_id' => $this->id])->one())
                    || ($a = ReceiptVoucher::class::find()->where(['owner_id'=>$this->id])->one())
                    || ($a = OrderInfo::class::find()->where(['sender_id'=>$this->id,'sender_type'=>$this->role])->one())
                    )
                )
                // renter
                ||($this->role === 'renter' && (
                    ($a = Installment::find()->where(['renter_id' => $this->id])->one())
                    || ($a = Contract::find()->where(['renter_id' => $this->id])->one())
                    || ($a = OrderInfo::class::find()->where(['sender_id'=>$this->id,'sender_type'=>$this->role])->one())
                    )
                )
                // admin User
                ||(in_array($this->role, ['admin','admin_user']) && (
                    ($a = EstateOffice::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = EstateOfficeBuilding::class::find()->where(['user_id' => $this->id])->one())
                    || ($a = MaintenanceOffice::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = BalanceSms::class::find()->where(['user_id' => $this->id])->one())
                    || ($a = BalanceContract::class::find()->where(['user_id' => $this->id])->one())
                    || ($a = Contract::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = MaintenanceInvoice::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = SystemExpense::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = SystemIncome::class::find()->where(['user_created_id' => $this->id])->one())
                    || ($a = MessageSms::class::find()->where(['user_created_id' => $this->id])->one())
                    )
                )   
                // all
                || ($a = ChatHistory::class::find()->where(['user_id' => $this->id])->one())
             ) ){

                Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
                if(in_array($this->role, ['renter','owner'])){
                    EstateOfficeBuilding::deleteAll(['owner'=>$this->id]);
                    EstateOfficeOwner::deleteAll(['owner_id'=>$this->id,]);
                    EstateOfficeRenter::deleteAll(['renter_id'=>$this->id,]);
                    Notification::deleteAll(['receiver_id'=>$this->id,'receiver_type'=>$this->role]);
                    OrderInfo::deleteAll(['sender_id'=>$this->id,'sender_type'=>$this->role]);
                    Chat::deleteAll(['sender_id'=>$this->id,'sender_type'=>$this->role]);
                    Chat::deleteAll(['receiver_id'=>$this->id,'receiver_type'=>$this->role]);
                }
                
                UserEstateOffice::deleteAll(['user_id'=>$this->id]);
                UserMaintenanceOffice::deleteAll(['user_id'=>$this->id]);
                Attachment::deleteAll(['item_id'=>$this->id , 'item_type' => $this->tableName() ]);
                GeneralHelpers::deleteImagesByPostId($this::class,$this->id);
                return true;
            }else{
                Yii::$app->session->setFlash('danger',
                    yii::t('app','cannot delete {item} has items from {items}.',[
                        'item' =>yii::t('app','User') ,'items' => yii::t('app','other items')
                    ])
                );
            }
        } 

        return false;
        
    }

    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->Orwhere(['email'=>$username])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

   
    public function getId()
    {
        return $this->getPrimaryKey();
    }

   
    public function getAuthKey()
    {
        return $this->auth_key;
    }


    public function getOtherUserType()
    {
        if($this->user_type === 'owner_estate_officer')
            return 'owner_estate_officer';
        else
            return 'estate_officer';

        // return 'braa';
    }

    public function getRole()
    {
        switch ($this->user_type) {
            case 'owner':
                return 'owner';
                break;
            case 'renter':
                return 'renter';
                break;
            case 'owner_estate_officer':
            case 'estate_officer':
            case 'estate_officer_user':
                return 'estate_officer';
                break;
            case 'admin':
            case 'admin_user':
                return 'admin';
                break;
            case 'maintenance_officer':
            case 'maintenance_officer_user':
                return 'maintenance_officer';
                break;
            case 'developer':
                return 'developer';
                break;
            default:
                return $this->user_type;
                break;
        }

        return $this->user_type;
    }

   
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public static function findByVerificationToken($token) {
        return static::findOne([
            'activation_code' => $token,
            'status' => self::STATUS_DELETED
        ]);
    }

    public static function sendActiveEmail($email)
    {
        $user = self::findOne([
            'email' => $email,
            'status' => User::STATUS_DELETED
        ]);

        if ($user === null) {
            return false;
        }
            $confirmLink =Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->activation_code]);
        //print_r($confirmLink); die();

            $to = $user->email;
            $siteName = Yii::$app->SiteSetting->siteName();
            $subject =yii::t('app','Account registration at ') . $siteName;
            $message = "
            <html>
            <head>
            <title>" . $subject . "</title>
            </head>
            <body>
            <div class=\"email-confirm\">
                <p>". yii::t('app', 'HELLO {username}', ['username' => $user->username]) ." !</p>
                <p>".yii::t('app', 'FOLLOW TO CONFIRM EMAIL') .":</p>
                <p>".Html::a(Html::encode($confirmLink), $confirmLink) ."</p>
            </div>
            </body>
            </html>
            ";
            //print_r($message ); die();
        return GeneralHelpers::sendEmail($to, $subject, $message);
    }

    public function getIdentityType()
    {
        return $this->hasOne(\common\models\IdentityType::class, ['id' => 'identity_type_id']);
    }

    public function getNationality()
    {
        return $this->hasOne(\common\models\Nationality::class, ['id' => 'nationality_id']);
    }
    
    public function getUserEstateOffice()
    {
        return $this->hasOne(UserEstateOffice::class, ['user_id' => 'id']);
    }

    public function getUserMaintenanceOffice()
    {
        return $this->hasOne(UserMaintenanceOffice::class, ['user_id' => 'id']);
    }
    /*
    * send message to email
    */
    /*public static function sendEmail($to_email, $subject, $message, $from, $fileView = null)
    {
        
        return GeneralHelpers::sendEmail($to_email, $subject, $message, $from);
        
    }*/


    public function eventNew($event){ 
        $estate_office_id = (\common\components\GeneralHelpers::getEstateOfficeId())? :null;

        $params = [
            're_id' => $this->id ,
            're_type' =>  'user',
            'content' => 'your account is ready' ,
            'id' => $this->id,
            't_name' => 'profile',
            'mobile' => $this->mobile,
            'email' => $this->email,
            
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'url' => Yii::$app->BaseUrl->baseUrl,
        ];
        
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW,$params,$estate_office_id);
    }


    // public function setIdentity($identity)
    // {
    //     die();
    //         Yii::$app->session->name = "sdff_fafaf";

    //         $this->_identity = yii::$app->user2;
    //     // if ($identity instanceof IdentityInterface) {
    //     // } elseif ($identity === null) {
    //     //     $this->_identity = null;
    //     // } else {
    //     //     throw new InvalidValueException('The identity object must implement IdentityInterface.');
    //     // }
    //     $this->_access = [];
    // }

}
