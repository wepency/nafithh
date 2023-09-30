<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_history".
 *
 * @property int $id
 * @property int $chat_id
 * @property string $message
 * @property int $user_id
 * @property string $created_date
 * @property int $status_read
 *
 * @property Chat $chat
 */
class ChatHistory extends \yii\db\ActiveRecord
{
    const NOTIF_TEMP_NEW = 1;
    const EVENT_NEW = 'eventNew';

    public function init(){
      $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
      parent::init(); // DON'T Forget to call the parent method.
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' =>
                    [
                        \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                    ],
                'value' => function(){
                    return Yii::$app->user->identity->id;
                    
                }
            ], 
        ];
    }
    public static function tableName()
    {
        return 'chat_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['chat_id', 'user_id', 'status_read'], 'integer'],
            [['message'], 'string','min' => 3],
            [['status_read'], 'default', 'value' => 0],
            [['created_date'], 'safe'],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::class, 'targetAttribute' => ['chat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chat_id' => Yii::t('app', 'Chat ID'),
            'message' => Yii::t('app', 'Message'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_date' => Yii::t('app', 'Created Date'),
            'status_read' => Yii::t('app', 'Status Read'),
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery|common\query\ChatQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::class, ['id' => 'chat_id']);
    }

    /**
     * {@inheritdoc}
     * @return ChatHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\query\ChatHistoryQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function senderName()
    {
        $chat = $this->chat;
        $name = '';
        if($this->currentIsSenserd()){
            $name .= $chat->Sender['type'].': ';
            $name .= (isset($chat->Sender['office_name'])? $chat->Sender['office_name'].': ' : '');
        }else{
            $name .= $chat->receiver['type'].': ';
            $name .= (isset($chat->receiver['office_name'])? $chat->receiver['office_name'].': ' : '');
        }
        $name .= '('.$this->user->name.')';
        return $name;
    }

    public function image()
    {
        $chat = $this->chat;
        if($office = $chat->officeByUser($this->user->id)){
            $image = $office->logo;
        }else{
            $image = $this->user->avatar;
        }
        $image = ($image) ? $image : yii::$app->uploadUrl->baseUrl.'/user/default.png';
    
        return $image;
    }


    public function date()
    {
        $date = \common\components\GeneralHelpers::formatDate($this->created_date)[0];
        $date .= ' '. \common\components\GeneralHelpers::formatDate($this->created_date)[1];
        return $date;
    }


    public function currentIsSenserd()
    {
        $infoHistory = Chat::getInfoUser($this->user->id);
        if($infoHistory['userId'] == $this->chat->sender_id && $infoHistory['userType'] == $this->chat->sender_type )
            return true;
        else
            return false;
    }


    public function eventNew($event){
        $estate_office_id = (\common\components\GeneralHelpers::getEstateOfficeId())? :null;
        
        if($this->currentIsSenserd()){
            $re_id = $this->chat->receiver_id;
            $re_type = $this->chat->receiver_type;
            $re_data = $this->chat->receiver;
        }else{
            $re_id = $this->chat->sender_id;
            $re_type = $this->chat->sender_type;
            $re_data = $this->chat->sender;
        }
        $re_data = (isset($re_data['office_data'])) ? $re_data['office_data'] : ((isset($re_data['user_data'])) ? $re_data['user_data'] : User::findOne(1));
        $params = [
            're_id' => $re_id ,
            're_type' => $re_type ,
            'content' => 'You have a new Message' ,
            'id' => $this->id,
            't_name' => 'chat',
            'mobile' => $re_data->mobile,
            'email' => $re_data->email,
            
            'sender_name' => $this->senderName(),
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW,$params,$estate_office_id);
       // you code 
    }
}
