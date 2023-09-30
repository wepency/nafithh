<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notif_temp".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $title_email
 * @property string $title_email_en
 * @property string $body_email
 * @property string $body_email_en
 * @property string $body_sms
 * @property string $hint
 * @property string $hint_en
 * @property string $body_sms_en
 * @property int $enable_sms
 * @property int $enable_email
 * @property int $enable_system
 */
class NotifTemp extends \yii\db\ActiveRecord
{
    public $_name;
    public $_title_email;
    public $_body_email;
    public $_body_sms;
    public $_hint;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notif_temp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_email', 'title_email_en', 'body_email', 'body_email_en', 'body_sms', 'body_sms_en',  'enable_sms', 'enable_email'], 'required'],
            [['enable_sms', 'enable_email','enable_system'], 'default', 'value' => 0],

            [['body_email', 'body_email_en', 'body_sms', 'body_sms_en'], 'string'],
            [['enable_sms', 'enable_email','enable_system'], 'integer'],
            [['name', 'name_en', 'title_email', 'title_email_en'], 'string', 'max' => 200],
            [['hint', 'hint_en',], 'string', 'max' => 5000],
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
            'name_en' => Yii::t('app', 'Name En'),
            'title_email' => Yii::t('app', 'Title Email'),
            'title_email_en' => Yii::t('app', 'Title Email En'),
            'body_email' => Yii::t('app', 'Body Email'),
            'body_email_en' => Yii::t('app', 'Body Email En'),
            'body_sms' => Yii::t('app', 'Body Sms'),
            'body_sms_en' => Yii::t('app', 'Body Sms En'),
            'hint' => Yii::t('app', 'Hint'),
            'hint_en' => Yii::t('app', 'Hint EN'),
            'enable_sms' => Yii::t('app', 'Enable Sms'),
            'enable_email' => Yii::t('app', 'Enable Email'),
            'enable_system' => Yii::t('app', 'Enable System'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_name = $this->name;
            $this->_title_email = $this->title_email;
            $this->_body_email = $this->body_email;
            $this->_body_sms = $this->body_sms;
            $this->_hint = $this->hint;
        }else{
            $this->_name = $this->name_en;
            $this->_title_email = $this->title_email_en;
            $this->_body_email = $this->body_email_en;
            $this->_body_sms = $this->body_sms_en;
            $this->_hint = $this->hint_en;
        }
    }
}


// 1 / Messages - New Message
// 2 / Contracts - New Contract - for Estate Office
// 3 / Contracts - New Contract - for Renter
// 4 / contracts - Near the expiry Renter contract-  for Owner
// 5 / Installements - start date Installement- for Renter
// 6 / Installements - Near payment date- for Estate Office
// 7 / Installements - New Installement- for Renter
// 8 / Installements - Payment- for renter
// 9 / Installements - Payment- for Estate Office And Owner
// 10 / Building-  view As Renter Or pay- for Estate Office
// 11 / Building-  view As Renter Or pay- for Owners
// 12 / Building - building Created -  for Owner
// 13 / Owner Created -  for system
// 16 / Renter Created -  for system
// 17 / Offices - near the expiry subscription contract - for estate and maintenance offices
// 18 / Maintenance - new request - for maintenance offices
// 19 / Maintenance - Quotation - to the requester
// 20 / Maintenance - accept maintenance - for the maintenance office
// 21 / Maintenance - Close maintenance order- for order sender 
// 22 / Maintenance - replay to the order- for order sender 
