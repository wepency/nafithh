<?php

namespace common\models;
use common\components\GeneralHelpers;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $sender_id
 * @property string $sender_type
 * @property int $receiver_id {office_id or user_id} 0=> if user admin 
 * @property string $receiver_type
 * @property string $title
 * @property string|null $created_at
 *
 * @property ChatHistory[] $chatHistories
 */


class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_id', 'receiver_type', 'title'], 'required'],
            [['sender_id', 'receiver_id'], 'integer'],
            [['created_at'], 'safe'],
            [['sender_type', 'receiver_type'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'sender_type' => Yii::t('app', 'Sender Type'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'receiver_type' => Yii::t('app', 'Receiver Type'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            if(!$this->currentIsCreated() ){
                Yii::$app->session->setFlash('danger',
                    yii::t('app','A conversation can only be deleted by the originator of the message'));
                return false;
            }
            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
            ChatHistory::deleteAll(['chat_id'=>$this->id ]);
            Attachment::deleteAll(['item_id'=>$this->id , 'item_type' => $this->tableName() ]);
            GeneralHelpers::deleteImagesByPostId($this::class,$this->id);
            return true;
        } 
        return false;
    }

    /**
     * Gets query for [[ChatHistories]].
     *
     * @return \yii\db\ActiveQuery|ChatHistoryQuery
     */
    public function getChatHistories()
    {
        return $this->hasMany(ChatHistory::class, ['chat_id' => 'id']);
    }

    public function isHasNew()
    {
        $history = \common\models\ChatHistory::find()->where(['chat_id' => $this->id])->unread()->all();

        return (count($history)>0)? true: false;
    }

    /**
     * {@inheritdoc}
     * @return ChaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\query\ChatQuery(get_called_class());
    }

    /*
    $attrType = [sender_type or receiver_type]
    $attrId = [sender_id or receiver_id]
    */
    public function getSender($attrType = 'sender_type' ,$attrId = 'sender_id')
    {
        $sender;
        $user = User::findOne($this->$attrId);
        $sender['user_data'] = $user;
        $sender_type = $this->$attrType;
        $sender['type'] =  yii::$app->params['userType'][Yii::$app->language][$sender_type];

        switch ($sender_type) {
            case 'owner':
            case 'renter':
                break;
            case 'admin':
                $sender['type'] = yii::t('app',"System");
                $sender['office_name'] = yii::$app->SiteSetting->info()->_site_name ;
                break;
            case 'estate_officer':
                // $sender['type'] = yii::t('app',"Estate Office");
                $sender['office_data'] = EstateOffice::findOne($this->$attrId);
                $sender['office_name'] = EstateOffice::findOne($this->$attrId)->name ;
                $sender['user_data'] = EstateOffice::findOne($this->$attrId)->admin;
                break;
            case 'maintenance_officer':
                // $sender['type'] = yii::t('app',"Maintenance Office");
                $sender['user_data'] = MaintenanceOffice::findOne($this->$attrId)->admin;
                $sender['office_data'] = MaintenanceOffice::findOne($this->$attrId);
                $sender['office_name'] = MaintenanceOffice::findOne($this->$attrId)->name ;
                break;
            default:
                return null;
                break;
        }
        return $sender;
    }

    public function getReceiver()
    {
        return $this->getSender('receiver_type','receiver_id');
    }

    /*
    */
    public static function officeByUser($user_id)
    {
        $user = User::findOne($user_id);
        if($user->role == 'estate_officer'){
            $office_id = $user->userEstateOffice->estate_office_id;
            return EstateOffice::findOne($office_id);
        }
        elseif($user->role == 'maintenance_officer'){
            $office_id = $user->userMaintenanceOffice->maintenance_office_id;
            return MaintenanceOffice::findOne($office_id) ;
        }
        else
            return null;
    }


    public static function getInfoUser($user_id = null){

        $user = ($user_id == null) ? yii::$app->user->identity : User::findOne($user_id);
        $current['userId']='';
        $current['userType'] = $user->role;
        switch ($user->role) {
            case 'owner':
            case 'renter':
                $current['userId'] = $user->id;
                break;
            case 'estate_officer':
                $estate_office_id = ($user_id == null) ? GeneralHelpers::getEstateOfficeId() : self::officeByUser($user_id)->id ;
                $current['userId'] = $estate_office_id;
                break;
            case 'admin':
                $current['userId'] = 0;
                break;
            case 'maintenance_officer':
                $maintenance_office_id = ($user_id == null) ? GeneralHelpers::getMaintenanceOfficeId() : self::officeByUser($user_id)->id ;
                $current['userId'] = $maintenance_office_id;
                break;
            case 'developer':
                $current['userId'] = 0;
                break;
            default:
                # code...
                break;
        }

        return $current;
    }

    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) { // only on insert
                $info = $this->getInfoUser();
                $this->sender_type = $info['userType'];
                $this->sender_id = $info['userId'];
            }
            return true;
        }
        return false;
    }

    public function currentIsCreated()
    {
         $info = $this->getInfoUser();
         if($this->sender_id == $info['userId'] && $this->sender_type == $info['userType'] )
            return true;
        else
            return false;
    }

    public static function listReceivers()
    {
        Chat::getInfoUser();
        $sender_type = Chat::getInfoUser()['userType'];
        $list = $senderTo = array();
        switch ($sender_type) {
            case 'owner':
                $list = array('admin','estate_officer','maintenance_officer','renter');
                break;
            case 'renter':
                $list = array('admin','estate_officer','maintenance_officer');
                break;
            case 'admin':
                $list = array('estate_officer','owner','maintenance_officer','renter');
                break;
            case 'maintenance_officer':
                $list = array('admin');
                break;
                // إذا كان المستخدم مالك عقار  أو مكتب عقار
            case 'estate_officer':
                $list = array('admin','estate_officer','maintenance_officer','renter','owner');
                break;
            default:
                $list = array('admin','estate_officer','owner','maintenance_officer','renter');
            break;
        }
        foreach ($list as $row ) {
            $senderTo[$row] = yii::t('app',yii::$app->params['userType'][Yii::$app->language][$row]);
        }
        return $senderTo;
    }
}
