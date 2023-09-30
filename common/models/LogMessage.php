<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_message".
 *
 * @property int $id
 * @property int $sender_id إذا كان 0 فالمرسل هو الأدمن
 * @property string $sender_type
 * @property int $notif_temp_id
 * @property int $receiver_id
 * @property string $receiver_type
 * @property string|null $contact_mobile
 * @property string|null $contact_email
 * @property string|null $message
 * @property string|null $status
 * @property string $created_date
 */
class LogMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'notif_temp_id', 'receiver_id'], 'integer'],
            [['notif_temp_id', 'receiver_type'], 'required'],
            [['message'], 'string'],
            [['created_date'], 'safe'],
            [['sender_type', 'receiver_type'], 'string', 'max' => 30],
            [['contact_mobile'], 'string', 'max' => 50],
            [['contact_email'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 255],
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
            'notif_temp_id' => Yii::t('app', 'Notif Temp ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'receiver_type' => Yii::t('app', 'Receiver Type'),
            'contact_mobile' => Yii::t('app', 'Contact Mobile'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'message' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }
}
