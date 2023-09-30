<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "installment_receipt_catch".
 *
 * @property int $id
 * @property int $installment_id
 * @property int|null $user_receive_id المستخدم الذي قام بتأكيد الدفع
 * @property string $receipt_catch_no رقم سند القبض
 * @property int|null $payment_method {1 = cash , 2- deposit bank , 3- electronic payment , 4-network}
 * @property int|null $payment_status {0= no paid , 2= paid , 1=part was paid ,3=>cancelled}
 * @property float|null $amount_paid المبلغ المدفوع
 * @property float|null $amount_remaining المبلغ المتبقي
 * @property string|null $details
 * @property string|null $created_date
 *
 * @property Installment $installment
 * @property User $userReceive
 */
class InstallmentReceiptCatch extends \yii\db\ActiveRecord
{
    public $imageFiles;
 
    const NOTIF_TEMP_PAID_RENTER = 8;
    const NOTIF_TEMP_PAID_ESTATE_AND_OWNER = 9;
    const EVENT_PAID = 'eventPaid';
    
    public function init(){
      $this->on(self::EVENT_PAID, [$this, self::EVENT_PAID]);
      parent::init(); // DON'T Forget to call the parent method.
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
            // [
            //     'class' => 'yii\behaviors\BlameableBehavior',
            //     'attributes' =>
            //         [
            //             \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_receive_id',
            //         ],
            //     'value' => function(){
            //         return Yii::$app->user->identity->id;
                    
            //     }
            // ],  
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'installment_receipt_catch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['installment_id','amount_paid', 'payment_method'], 'required'],
            [['installment_id', 'user_receive_id', 'payment_method', 'payment_status', 'receipt_catch_no'], 'integer'],
            [['amount_paid', 'amount_remaining'], 'number'],
            [['details'], 'string'],
            [['created_date'], 'safe'],
            [['amount_paid'],
                function ($attribute,$model) {
                    if (($this->amount_paid +  $this->installment->amount_paid) > $this->installment->amount ) {
                        $this->addError($attribute,Yii::t('app', 'Amount Paid').' '. yii::t('app','biger than').' '.Yii::t('app', 'Amount Remaining'));
                    }
                }],
            [['receipt_catch_no'], 'string', 'max' => 20],
            [['installment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Installment::class, 'targetAttribute' => ['installment_id' => 'id']],
            [['user_receive_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_receive_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx','mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','maxFiles' => 10],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'installment_id' => Yii::t('app', 'Installment'),
            'user_receive_id' => Yii::t('app', 'Received by user'),
            'receipt_catch_no' => Yii::t('app', 'Receipt Catch No'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'amount_paid' => Yii::t('app', 'Received amount'),
            'amount_remaining' => Yii::t('app', 'Remaining amount'),
            'details' => Yii::t('app', 'Other Details'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * Gets query for [[Installment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstallment()
    {
        return $this->hasOne(Installment::class, ['id' => 'installment_id']);
    }

    /**
     * Gets query for [[UserReceive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserReceive()
    {
        return $this->hasOne(User::class, ['id' => 'user_receive_id']);
    }

    public function eventPaid($event){
        $this->refresh();
        $params = [
            're_id' => $this->installment->renter_id ,
            're_type' => 'renter' ,
            'content' => 'paid installment success' ,
            'id' => $this->id,
            't_name' => 'installment',
            'mobile' => $this->installment->renter->mobile,
            'email' => $this->installment->renter->email,
            
            'receipt_no' => $this->id,
            'renter_name' => $this->installment->renter->name,
            'created_date' => Yii::$app->formatter->asDate($this->created_date, 'php:Y/m/d'),
            'amount_paid' => $this->amount_paid,
            'amount_remaining' => $this->amount_remaining,
            'housing_name' => $this->installment->contract->housingUnit->housing_unit_name,
        ];
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_PAID_RENTER,$params,$this->installment->contract->estate_office_id);

        $params = [
            're_id' => $this->installment->contract->estate_office_id ,
            're_type' => 'estate_officer' ,
            'content' => 'paid installment success' ,
            'id' => $this->id,
            't_name' => 'installment-receipt-catch',
            'mobile' => $this->installment->contract->estateOffice->mobile,
            'email' => $this->installment->contract->estateOffice->email,
            
            'receipt_no' => $this->id,
            'renter_name' => $this->installment->renter->name,
            'created_date' => Yii::$app->formatter->asDate($this->created_date, 'php:Y/m/d'),
            'amount_paid' => $this->amount_paid,
            'amount_remaining' => $this->amount_remaining,
            'housing_name' => $this->installment->contract->housingUnit->housing_unit_name,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_PAID_ESTATE_AND_OWNER,$params,$this->installment->contract->estate_office_id);

        $params = [
            're_id' => $this->installment->contract->owner_id ,
            're_type' => 'owner' ,
            'content' => 'paid installment success' ,
            'id' => $this->id,
            't_name' => 'installment-receipt-catch',
            'mobile' => $this->installment->contract->owner->mobile,
            'email' => $this->installment->contract->owner->email,
            
            'receipt_no' => $this->id,
            'renter_name' => $this->installment->renter->name,
            'created_date' => Yii::$app->formatter->asDate($this->created_date, 'php:Y/m/d'),
            'amount_paid' => $this->amount_paid,
            'amount_remaining' => $this->amount_remaining,
            'housing_name' => $this->installment->contract->housingUnit->housing_unit_name,
        ];
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_PAID_ESTATE_AND_OWNER,$params,$this->installment->contract->estate_office_id);
    }
}
