<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notif_temp_estate_office".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $title_email
 * @property string $title_email_en
 * @property string $body_email
 * @property string $body_email_en
 * @property string $body_sms
 * @property string $body_sms_en
 * @property int $enable_sms
 * @property int $enable_email
 * @property int $estate_office_id
 * @property int $notification_id
 */
class NotifTempEstateOffice extends \yii\db\ActiveRecord
{

    public $_name;
    public $_title_email;
    public $_body_email;
    public $_body_sms;
    public $enable_system;
    const  NOTIF_AVALIBAL_FOR_ESTATE_OFFICE = array(1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,19);
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notif_temp_estate_office';
    }

    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => 'yii\behaviors\BlameableBehavior',
    //             'attributes' =>
    //                 [
    //                     \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'estate_office_id',
    //                 ],
    //             'value' => function(){
    //                 $session = Yii::$app->session;
    //                 return $session['estate_office_id'];
                    
    //             }
    //         ],  
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'title_email', 'title_email_en', 'body_email', 'body_email_en', 'body_sms', 'body_sms_en', 'enable_sms', 'enable_email'], 'required'],

            [['enable_sms', 'enable_email'], 'default', 'value' => 0],

            [['body_email', 'body_email_en', 'body_sms', 'body_sms_en'], 'string'],
            [['enable_sms', 'enable_email', 'estate_office_id', 'notification_id'], 'integer'],
            [['name', 'name_en', 'title_email', 'title_email_en'], 'string', 'max' => 200],

            [['estate_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstateOffice::class, 'targetAttribute' => ['estate_office_id' => 'id']],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotifTemp::class, 'targetAttribute' => ['notification_id' => 'id']],
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
            'enable_sms' => Yii::t('app', 'Enable Sms'),
            'enable_email' => Yii::t('app', 'Enable Email'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
            'notification_id' => Yii::t('app', 'Notification ID'),
        ];
    }

     /**
     * Gets query for [[EstateOffice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }

    /**
     * Gets query for [[Notification]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(NotifTemp::class, ['id' => 'notification_id']);
    }


    public function afterFind()
    {
        parent::afterFind();

        $this->enable_system = $this->notification->enable_system;

        if (Yii::$app->language=='ar'){
            $this->_name = $this->name;
            $this->_title_email = $this->title_email;
            $this->_body_email = $this->body_email;
            $this->_body_sms = $this->body_sms;
        }else{
            $this->_name = $this->name_en;
            $this->_title_email = $this->title_email_en;
            $this->_body_email = $this->body_email_en;
            $this->_body_sms = $this->body_sms_en;
        }
    }

}
