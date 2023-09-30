<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $title
 * @property string $msg
 * @property string $created_at
 * @property string $replay_msg
 * @property int|null $user_id
 * @property int|null $contact_type_id
 * @property int $status
 */
class ContactUs extends \yii\db\ActiveRecord
{

    const NOTIF_TEMP_NEW = 111;
    const NOTIF_TEMP_NEW_SENDER = 112;
    const NOTIF_TEMP_REPLAY = 113;
    const EVENT_REPLAY = 'eventReplay';
    const EVENT_NEW = 'eventNew';

    public function init(){
      $this->on(self::EVENT_REPLAY, [$this, self::EVENT_REPLAY]);
      $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
      parent::init(); // DON'T Forget to call the parent method.
    }

    public function behaviors()
    {
        return [
            'uploadFilesBehavior' => [ 
                'class' =>\common\behaviors\UploadFilesBehavior::class,
                'setRule' => false,
                'relationOptions' => [
                    'fileAttribute' => 'imageFiles',
                    'configAttribute' => 'filesConfig',
                    'class' => Attachment::class,
                    'moreAttributes' => ['title','type','size'],
                ],
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
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email','mobile','contact_type_id', 'title', 'msg'], 'required'],
            [['msg', 'replay_msg'], 'string'],
            [['created_at'], 'safe'],
            [['email'], 'email'],
            [['contact_type_id'], 'default','value'=>1],
            [['user_id', 'status','contact_type_id'], 'integer'],
            [['name', 'email', 'mobile', 'title'], 'string', 'max' => 100],
            [['contact_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContactType::class, 'targetAttribute' => ['contact_type_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,png, jpg,jpeg','maxFiles' => 4],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'title' => Yii::t('app', 'Message Title'),
            'msg' => Yii::t('app', 'Msg'),
            'created_at' => Yii::t('app', 'Created At'),
            'replay_msg' => Yii::t('app', 'Replay Msg'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'contact_type_id' => Yii::t('app', 'Contact Type'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getContactType(){
        return $this->hasOne(ContactType::class, ['id' => 'contact_type_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // assign role after saving/creating the record:
        if ( $insert ){
            $this->trigger(self::EVENT_NEW);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function eventReplay($event){
        $params = [
            're_id' => Null ,
            're_type' =>  '',
            // 'content' => $this->replay_msg ,
            'id' => $this->id,
            't_name' => 'contact_us',
            'mobile' => $this->mobile,
            'email' => $this->email,

            'name' => $this->name,
            'title' => $this->title,
            'RepMsg' => $this->replay_msg,
        ];
        // print_r($params); die();
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_REPLAY,$params);
    }

    public function eventNew($event){
        $this->refresh();
        
        $siteSetting = yii::$app->SiteSetting->info();
        // print_r($this->id); die();

        $params = [
            're_id' => 0 ,
            're_type' =>  'admin',
            // 'content' => $this->replay_msg ,
            'id' => $this->id,
            't_name' => 'contact-us',
            'mobile' => $siteSetting->mobile,
            'email' => $siteSetting->contact_email,

            'name' => $this->name,
            'title' => $this->title,
            'msg' => $this->msg,
            'date' => $this->created_at,

        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW,$params);

        $params = [
            're_id' => NULL ,
            're_type' =>  '',
            // 'content' => $this->replay_msg ,
            'id' => $this->id,
            't_name' => 'contact-us',
            'mobile' => $this->mobile,
            'email' => $this->email,

            'name' => $this->name,
            'title' => $this->title,
            'msg' => $this->msg,
            'date' => $this->created_at,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW_SENDER,$params);
    }
}
