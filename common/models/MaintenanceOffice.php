<?php

namespace common\models;

use Yii;
use common\components\GeneralHelpers;

/**
 * This is the model class for table "maintenance_office".
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property string $registration_code
 * @property string $auth_person
 * @property string $mobile
 * @property string|null $phone
 * @property string $email
 * @property string $registration_date
 * @property string|null $expire_date
 * @property int $status_account
 * @property string|null $description
 * @property int $city_id
 * @property int $district_id
 * @property int $admin_id
 * @property string $lang
 * @property string $lat
 * @property string|null $header_report_image
 * @property string|null $footer_report_image
 * @property string|null $tax_num
 * @property int $user_created_id
 * @property int|null $tax
 */
class MaintenanceOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $imageFiles;
    public $_nationality_id;
    public $_username;
    public $_password;
    
    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'logo',
                'saveDir' => Yii::getAlias("@upload/maintenance_office/")
            ], 
            'uploadBehavior2' => [ 
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'header_report_image',
                'saveDir' => Yii::getAlias("@upload/maintenance_office/")
            ], 
            'uploadBehavior3' => [ 
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'footer_report_image',
                'saveDir' => Yii::getAlias("@upload/maintenance_office/")
            ], 
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
            [
            'class' => 'yii\behaviors\BlameableBehavior',
            'attributes' =>
                [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_created_id',
                ],
            'value' => function(){
                return Yii::$app->user->identity->id?? null;
            }
        ], 
        ];
    }

    public static function tableName()
    {
        return 'maintenance_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'registration_code', 'auth_person', 'mobile', 'email', 'city_id', 'district_id','_nationality_id'], 'required'],
            // [['_username', '_password'], 'required','on'=>'create'],
            ['_username', 'validateUsername','on'=>'create'],
            [['registration_date', 'expire_date'], 'safe'],
            [['status_account', 'city_id', 'district_id', 'user_created_id', 'tax','_nationality_id','admin_id'], 'integer'],
            [['mobile'], 'match', 'pattern' => '/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/' ,'message'=>yii::t('app','5xxxxxxxx')],
            
            [['email'], 'email'],
            ['email', 'unique','on'=>'create','targetClass'=> User::class,'targetAttribute'=>'email','message'=>yii::t('app','This email address has already been taken.')],
            ['email', 'unique','message'=>yii::t('app','This email address has already been taken.')],

            ['mobile', 'unique','on'=>'create','targetClass'=> User::class,'targetAttribute'=>'mobile','message'=>yii::t('app','This mobile has already been taken.')],
            ['mobile', 'unique','message'=>yii::t('app','This mobile has already been taken.')],

            ['registration_code', 'unique','on'=>'create','targetClass'=> User::class,'targetAttribute'=>'identity_id','message'=>yii::t('app','This Identity Number has already been taken.')],
            ['registration_code', 'unique','message'=>yii::t('app','This Registration Code has already been taken.')],

            [['description'], 'string'],
            [['name', 'logo', 'auth_person','_username', '_password'], 'string', 'max' => 150],
            [['registration_code', 'lang', 'lat'], 'string', 'max' => 70],
            [['mobile', 'phone'], 'string', 'max' => 20],
            [['email', 'header_report_image', 'footer_report_image'], 'string', 'max' => 200],
            [['tax_num'], 'string', 'max' => 50],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','maxFiles' => 10],
            [['tax'], 'integer' ,'min' => 0 , 'max' => 100],


        ];
    }

    public function validateUsername()
    {
        
        $user = User::findByUsername($this->_username);

        if (isset($user->id)) {
            $this->addError('_username', 'This username has already been taken.');
        }
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $result = 
                (MaintenanceInvoice::class::find()->where(['office_id' => $this->id])->one())? 'Maintenance Invoices': (
                (OrderMaintenance::class::find()->where(['maintenance_office_id' => $this->id])->one()) ? 'Order Maintenances': (
                (ReceiptVoucher::class::find()->where(['maintenance_office_id' => $this->id])->one()) ? 'Receipt Vouchers' :
                null));  
            if($result !== null){
                Yii::$app->session->setFlash('danger',
                    yii::t('app','cannot delete {item} has items from {items}.',[
                        'item' =>yii::t('app','Maintenance Offices') ,'items' => yii::t('app',$result)
                    ])
                );
                return false;
            }

            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));

              if($this->admin && !\common\components\MultiUserType::deleteUserType($this->admin,'maintenance_officer'))
                  User::deleteAll(['id'=>$this->admin->id]);
              Chat::deleteAll(['sender_id'=>$this->id,'sender_type'=>'maintenance_officer']);
              Chat::deleteAll(['receiver_id'=>$this->id,'receiver_type'=>'maintenance_officer']);
              UserMaintenanceOffice::deleteAll(['maintenance_office_id'=>$this->id]);
              Attachment::deleteAll(['item_id'=>$this->id , 'item_type' => $this->tableName() ]);
              GeneralHelpers::deleteImagesByPostId($this::class,$this->id);
              return true;
        } 

        return false;
        
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'registration_code' => Yii::t('app', 'Registration Code'),
            'auth_person' => Yii::t('app', 'Auth Person'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'registration_date' => Yii::t('app', 'Registration Date'),
            'expire_date' => Yii::t('app', 'Expire Date'),
            'status_account' => Yii::t('app', 'Status Account'),
            'description' => Yii::t('app', 'Description'),
            'city_id' => Yii::t('app', 'City'),
            'district_id' => Yii::t('app', 'District'),
            'lang' => Yii::t('app', 'Lang'),
            'lat' => Yii::t('app', 'Lat'),
            'header_report_image' => Yii::t('app', 'Header Report Image'),
            'footer_report_image' => Yii::t('app', 'Footer Report Image'),
            'tax_num' => Yii::t('app', 'Tax Num'),
            'user_created_id' => Yii::t('app', 'User Created'),
            'tax' => Yii::t('app', 'System Percent'),
        ];
    }


    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }


    public function getAdmin()
    {
       return $this->hasOne(User::class, ['id' => 'admin_id']);
    }

    public function getUserMaintenanceOffice()
   {
       return $this->hasMany(UserMaintenanceOffice::class, ['maintenance_office_id' => 'id']);
   }
}
