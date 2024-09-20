<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms_provider".
 *
 * @property int $id
 * @property string $domain
 * @property string $username
 * @property string $password
 * @property string $sender
 * @property string $sendgrid_username
 * @property string $sendgrid_password
 * @property int $paypal_type
 * @property string $sandbox
 * @property string $production
 * @property int $sending_status
 */
class SmsProvider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_provider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'username', 'password', 'sender', 'sendgrid_username', 'sendgrid_password', 'paypal_type', 'sandbox', 'production', 'sending_status'], 'required'],
            [['paypal_type', 'sending_status'], 'integer'],
            [['domain'], 'string', 'max' => 50],
            [['username', 'password', 'sender', 'sendgrid_username', 'sendgrid_password', 'sandbox', 'production'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'domain' => Yii::t('app', 'Domain'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'sender' => Yii::t('app', 'Sender'),
            'sendgrid_username' => Yii::t('app', 'Sendgrid Username'),
            'sendgrid_password' => Yii::t('app', 'Sendgrid Password'),
            'paypal_type' => Yii::t('app', 'Paypal Type'),
            'sandbox' => Yii::t('app', 'Sandbox'),
            'production' => Yii::t('app', 'Production'),
            'sending_status' => Yii::t('app', 'Sending Status'),
        ];
    }
}
