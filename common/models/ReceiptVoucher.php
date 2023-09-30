<?php

namespace common\models;
use common\components\GeneralHelpers;

use Yii;

/**
 * This is the model class for table "receipt_voucher".
 *
 * @property int $id
 * @property string|null $recipient_type {owner , maintenance_officer,other}
 * @property int|null $owner_id
 * @property int $estate_office_id
 * @property int|null $building_housing_unit_id
 * @property int|null $maintenance_office_id
 * @property float|null $amount مبلغ السند
 * @property string $amount_text
 * @property string|null $receipt_voucher_no رقم سند القبض
 * @property string|null $pay_against
 * @property int|null $payment_method {1 = cash , 2- deposit bank , 3- electronic payment , 4-network}
 * @property int|null $user_receipt_id المستخدم الذي قام  بتحرير السند
 * @property int|null $payment_status_estate {0= no paid , 2= paid , 1=part was paid ,3=>cancelled}
 * @property string|null $created_date
 * @property string|null $details
 *
 * @property BuildingHousingUnit $buildingHousingUnit
 * @property User $owner
 * @property User $userReceipt
 * @property EstateOffice $estateOffice
 * @property MaintenanceOffice $maintenanceOffice
 */
class ReceiptVoucher extends \yii\db\ActiveRecord
{

    const EVENT_STATEMENT = 'eventCreateStatement';
    const EVENT_STATEMENT_MAINTENANCE = 'eventCreateMaintenanceStatement';

    public function init(){
      $this->on(self::EVENT_STATEMENT, [$this, self::EVENT_STATEMENT]);
      $this->on(self::EVENT_STATEMENT_MAINTENANCE, [$this, self::EVENT_STATEMENT_MAINTENANCE]);
      parent::init(); // DON'T Forget to call the parent method.
    }

    public $imageFiles;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_voucher';
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
                        \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_receipt_id',
                    ],
                'value' => function(){
                    return Yii::$app->user->identity->id;
                    
                }
            ], 
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' =>
                    [
                        \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'estate_office_id',
                    ],
                'value' => function(){
                    return \common\components\GeneralHelpers::getEstateOfficeId();
                    
                }
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
            
            'convertNumToTextBehavior' =>  [ 
                'class' => \common\behaviors\ConvertNumToTextBehavior::class,
                // اسم الحقل الذي فيه المبلغ
                'numberAttribute' => 'amount',
                // اسم الحقل الذي سيضاف إليه المبلغ كنص
                'textNumberAttribute' => 'amount_text'
            ],  
        ];
    }
    
    public function rules()
    {
        return [
            [['owner_id', 'estate_office_id', 'building_housing_unit_id', 'maintenance_office_id', 'payment_method', 'user_receipt_id','payment_status_estate'], 'integer'],
            [['recipient_type','amount','pay_against','payment_method'], 'required'],
            [['amount'], 'number'],
            [['pay_against', 'details'], 'string'],
            [['created_date'], 'safe'],

            [['building_housing_unit_id','maintenance_office_id'], 'required', 'when' => function($model) {
                return $model->recipient_type == 'maintenance_officer';
            }, 'whenClient' => "function (attribute, value) {
                return $('#receiptvoucher-recipient_type').val() == 'maintenance_officer' ;
            }", 'message' => yii::t('app','You must select a Housing unit and Maintenance Office')],

            [['owner_id'], 'required', 'when' => function($model) {
                return $model->recipient_type == 'owner';
            }, 'whenClient' => "function (attribute, value) {
                return $('#receiptvoucher-recipient_type').val() == 'owner' ;
            }", 'message' => yii::t('app','You must select a Owner')],

            [['recipient_type', 'receipt_voucher_no'], 'string', 'max' => 20],
            [['amount_text'], 'string', 'max' => 500],
            [['building_housing_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingHousingUnit::class, 'targetAttribute' => ['building_housing_unit_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['user_receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_receipt_id' => 'id']],
            [['estate_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstateOffice::class, 'targetAttribute' => ['estate_office_id' => 'id']],
            [['maintenance_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaintenanceOffice::class, 'targetAttribute' => ['maintenance_office_id' => 'id']],

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
            'recipient_type' => Yii::t('app', 'Recipient Type'),
            'owner_id' => Yii::t('app', 'Owner'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'building_housing_unit_id' => Yii::t('app', 'Building Housing Unit'),
            'maintenance_office_id' => Yii::t('app', 'Maintenance Office'),
            'amount' => Yii::t('app', 'Amount'),
            'amount_text' => Yii::t('app', 'Amount Text'),
            'receipt_voucher_no' => Yii::t('app', 'Receipt Voucher No'),
            'pay_against' => Yii::t('app', 'Pay Against'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'user_receipt_id' => Yii::t('app', 'User Receipt'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payment_status_estate' => Yii::t('app', 'Payment Status Estate'),
            'details' => Yii::t('app', 'Details'),
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Attachment::deleteAll(['item_id'=>$this->id , 'item_type' => $this->tableName() ]);
            GeneralHelpers::deleteImagesByPostId($this::class,$this->id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[BuildingHousingUnit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingHousingUnit()
    {
        return $this->hasOne(BuildingHousingUnit::class, ['id' => 'building_housing_unit_id']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[UserReceipt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserReceipt()
    {
        return $this->hasOne(User::class, ['id' => 'user_receipt_id']);
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
     * Gets query for [[MaintenanceOffice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceOffice()
    {
        return $this->hasOne(MaintenanceOffice::class, ['id' => 'maintenance_office_id']);
    }


    public static function getListRecipient()
    {
        $list =\common\components\GeneralHelpers::translateParams(Yii::$app->params['recipient_type']);
        if(yii::$app->user->identity->user_type == 'owner_estate_officer'){
            unset($list['owner']);
        }
        return $list;
    }




    public function eventCreateStatement($event){
        if($this->recipient_type ==  'maintenance_officer' && $this->building_housing_unit_id ){
            $amount = $this->amount;
            $trans = new Statement();

            $building = $this->buildingHousingUnit->building;

            $trans->housing_id = $this->building_housing_unit_id ;
            $trans->building_id = $building->id;
            $trans->estate_office_id = $this->estate_office_id;
            $trans->owner_id = $building->owner_id;
            // $trans->contract_id = $this->id;
            $trans->type = 3;
            // $trans->debit = ;
            $trans->credit = $amount;
            $trans->reference_id =$this->id ;
            $trans->setDetail('maintenance',['amount'=> $amount,'receipt_voucher_id'=>$this->id]);
            $trans->save();
            $this->payment_status_estate = Installment::STATUS_UNPAID;

            $this->save();
           
        }
    }


    public function eventCreateMaintenanceStatement($event){
        $amount = $this->amount;
        $building = $this->buildingHousingUnit->building;

        $receiptCatch = New StatementReceiptCatch();
        $receiptCatch->amount_paid = $amount;
        $receiptCatch->estate_office_id = $this->estate_office_id;
        $receiptCatch->owner_id = $building->owner_id;
        $receiptCatch->setDetail('maintenance',['amount'=> $amount,'receipt_voucher_id'=>$this->id]);
        $receiptCatch->save();
        $receiptCatch->refresh();


        $trans = new Statement();
        $trans->housing_id = $this->building_housing_unit_id ;
        $trans->building_id = $building->id;
        $trans->estate_office_id = $this->estate_office_id;
        $trans->owner_id = $building->owner_id;
        // $trans->contract_id = $contract->id;
        $trans->type = 5;

        $trans->debit = $amount;
        // $trans->credit = ;
        $trans->reference_id = $receiptCatch->id;
        $trans->setDetail('receipt_catch_maintenance',['amount'=> $amount,'receipt_catch_id'=>$receiptCatch->id,'receipt_voucher_id'=>$this->id]);
        $trans->save();

       
    }


    public function setDetail($template,$params =[]){
        $text = '';

        switch ($template) {
            case 'statementOwner':
                $text_ar = ' ,للوحدات السكنية رقم  ({hounsing_ids})';
                $text = ' ,for Housings number ({hounsing_ids})';
                break; 
            default:
                // code...
                break;
        }
        // $this->detail = yii::t('app',$text,$params,'ar');
        $this->pay_against .= yii::t('app',$text_ar,$params,'ar');

    }
}
