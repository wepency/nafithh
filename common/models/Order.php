<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $mobile
 * @property string $email
 * @property string $company_name
 * @property string $detail_field
 * @property int|null $company_type
 * @property int|null $plan_id
 * @property int|null $payment_status {0= no paid , 2= paid , 1=part was paid}
 * @property string|null $created_date
 * @property int $status
 * @property int $response_by
 *
 * @property Plan $plan
 */
class Order extends \yii\db\ActiveRecord
{

    const NOTIF_TEMP_NEW = 115;
    const EVENT_NEW = 'eventNew';
    const NOTIF_TEMP_NEW_CUSTOMER = 116;
    // const EVENT_NEW_CUSTOMER = 'eventNewCustomer';

    public function init(){
        $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
        // $this->on(self::EVENT_NEW_CUSTOMER, [$this, self::EVENT_NEW_CUSTOMER]);
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
            'field_behavior' => [
                'class' => 'common\behaviors\JsonObjectBehavior',
                'attribute' => 'detail_field', //Name of the attribute that holds the JSON string
                'objectClass' => \common\modelField\DetailPayField::class, //Replace with your own class that extends JsonObjectModel
                'init' => true, // (new Model())->field will be an object
                // 'default' => [
                //     'sender_date'=> Yii::$app->formatter->asDate(time(),'php:Y-m-d'),
                // ], // If you need defaults 
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'/*, 'content'*/,'plan_id', 'mobile', 'email', 'company_type',/* 'company_name', 'status', 'response_by'*/], 'required'],
            [['content'], 'string'],
            [['detail_field'], 'safe'],
            [['created_date'], 'safe'],
            [['email'], 'email'],   
            [['plan_id', 'status', 'response_by', 'payment_status', 'company_type'], 'integer'],
            [['payment_status'],'default','value'=>Installment::STATUS_UNPAID],
            [['name', 'email', 'company_name'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => 0],
            [['response_by'], 'default', 'value' => User::find()->where(['user_type'=>'admin'])->one()->id],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['plan_id' => 'id']],
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
            'content' => Yii::t('app', 'Content'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'company_name' => Yii::t('app', 'Company Name'),
            'plan_id' => Yii::t('app', 'Plan'),
            'status' => Yii::t('app', 'Status'),
            'company_type' => Yii::t('app', 'Company Type'),
            'response_by' => Yii::t('app', 'Response By'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'created_date' => Yii::t('app', 'Created Date'),

        ];
    }

    /**
     * Gets query for [[Plan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::class, ['id' => 'plan_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // assign role after saving/creating the record:
        if ( $insert ){
            $this->trigger(self::EVENT_NEW);
        }
        parent::afterSave($insert, $changedAttributes);
    }


    public function eventNew($event){
        $siteSetting = yii::$app->SiteSetting->info();
        $params = [
            're_id' => 0 ,
            're_type' =>  'admin',
            // 'content' => $this->replay_msg ,
            'id' => $this->id,
            't_name' => 'order',
            'mobile' => $siteSetting->mobile,
            'email' => $siteSetting->email_admin,

            'name' => $this->name,
            'company_name' => $this->company_name,
            'planTitle' => $this->plan->_title,
            'planId' => $this->plan->id,
            'price' => $this->plan->price,
            'period' => yii::$app->params['period'][Yii::$app->language][$this->plan->period],
            'currency' => yii::$app->params['currency'][Yii::$app->language][$this->plan->currency],
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW,$params);

        if($this->email){

            $params = [
                're_id' => NULL ,
                're_type' =>  '',
                // 'content' => $this->replay_msg ,
                'id' => $this->id,
                't_name' => 'order',
                'mobile' => $this->mobile,
                'email' => $this->email,

                'company_name' => $this->company_name,
                'name' => $this->name,
                'planTitle' => $this->plan->_title,
                'planId' => $this->plan->id,
                'price' => $this->plan->price,
                'period' => yii::$app->params['period'][Yii::$app->language][$this->plan->period],
                'currency' => yii::$app->params['currency'][Yii::$app->language][$this->plan->currency],
            ];

            \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW_CUSTOMER,$params);
        }

    }

    public function getResponseBy()
    {
        return $this->hasOne(User::class, ['id' => 'response_by']);
    }
}
