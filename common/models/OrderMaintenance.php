<?php

namespace common\models;

use Yii;
use common\components\GeneralHelpers;

/**
 * This is the model class for table "order_maintenance".
 *
 * @property int $id
 * @property int $maintenance_office_id
 * @property int $order_info_id
 * @property string|null $note
 * @property float $price
 * @property int $status {1=>new -2=> pending_view - 3=>accept - 4=>not_accept - 5=>confirm-accept - 6=>replay_fix - 7=>pending_fix - 8=>finish_fix - 9=>active_fix - 10=>close }
 * @property int $status_accept 0=>no , 1=>yes
 * @property string|null $reason_disagree
 * @property int $commission_amount
 * @property date $payment_at
 * @property MaintenanceOffice $maintenanceOffice
 * @property OrderInfo $orderInfo
 */
class OrderMaintenance extends \yii\db\ActiveRecord
{

    const STATUS_PAIDED = 9;
    
    const NOTIF_TEMP_NEW = 15;
    const EVENT_NEW = 'eventNew';

    // عرض السهر 
    const NOTIF_TEMP_QUOTATION = 16;
    const EVENT_QUOTATION = 'eventQuotation';

    // غلق الطلب
    const NOTIF_TEMP_ORDER_CLOSE = 18;
    const EVENT_ORDER_CLOSE = 'eventOrderClose';

     // الرد على الطلب
    const NOTIF_TEMP_ORDER_REPLAY = 19;
    const EVENT_ORDER_REPLAY = 'eventOrderReplay';

    const NOTIF_TEMP_ACCEPT = 17;
    const EVENT_ACCEPT = 'eventAccept';

    public function init(){
      $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
      $this->on(self::EVENT_ACCEPT, [$this, self::EVENT_ACCEPT]);
      $this->on(self::EVENT_QUOTATION, [$this, self::EVENT_QUOTATION]);
      $this->on(self::EVENT_ORDER_CLOSE, [$this, self::EVENT_ORDER_CLOSE]);
      $this->on(self::EVENT_ORDER_REPLAY, [$this, self::EVENT_ORDER_REPLAY]);
      parent::init(); // DON'T Forget to call the parent method.
    }

    public $imageFiles;


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
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_maintenance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maintenance_office_id', 'order_info_id', 'price'], 'required'],
            [['maintenance_office_id', 'order_info_id', 'status', 'status_accept'], 'integer'],
            [['note', 'reason_disagree'], 'string'],
            [['price'], 'number'],
            [['payment_at'], 'safe'],
            [['commission_amount'], 'number'],
            [['maintenance_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaintenanceOffice::class, 'targetAttribute' => ['maintenance_office_id' => 'id']],
            [['order_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderInfo::class, 'targetAttribute' => ['order_info_id' => 'id']],
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
            'maintenance_office_id' => Yii::t('app', 'Maintenance Office'),
            'order_info_id' => Yii::t('app', 'Order Info'),
            'note' => Yii::t('app', 'Note'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'status_accept' => Yii::t('app', 'Status Accept'),
            'reason_disagree' => Yii::t('app', 'Reason Disagree'),
            'payment_at' => Yii::t('app', 'Payment At'),

            'commission_amount' => Yii::t('app', 'Commission Amount'),

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
     * Gets query for [[MaintenanceOffice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceOffice()
    {
        return $this->hasOne(MaintenanceOffice::class, ['id' => 'maintenance_office_id']);
    }

    /**
     * Gets query for [[OrderInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderInfo()
    {
        return $this->hasOne(OrderInfo::class, ['id' => 'order_info_id']);
    }


    public function eventNew($event){
        $estate_office_id = ($this->orderInfo->estate_office_id)? :null;

        $params = [
            're_id' => $this->maintenance_office_id ,
            're_type' => 'maintenance_officer' ,
            'content' => 'You have a new maintenance order' ,
            'id' => $this->id,
            't_name' => 'order-maintenance',
            'mobile' => $this->maintenanceOffice->mobile,
            'email' => $this->maintenanceOffice->email,
            
            'sender_name' => $this->orderInfo->sender->name,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW,$params,$estate_office_id);

    }

    public function eventAccept($event){
        $estate_office_id = ($this->orderInfo->estate_office_id)? :null;

        $params = [
            're_id' => $this->maintenance_office_id ,
            're_type' => 'maintenance_officer' ,
            'content' => 'You have a new maintenance order' ,
            'id' => $this->id,
            't_name' => 'order-maintenance',
            'mobile' => $this->maintenanceOffice->mobile,
            'email' => $this->maintenanceOffice->email,
            
            'sender_name' => $this->orderInfo->sender->name,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_ACCEPT,$params,$estate_office_id);
    }

    public function eventQuotation($event){
        $estate_office_id = ($this->orderInfo->estate_office_id)? :null;

        $params = [
            're_id' => $this->orderInfo->sender->id ,
            're_type' => $this->orderInfo->sender_type ,
            'content' => 'Quotation for Your Maintenance Order' ,
            'id' => $this->id,
            't_name' => 'order-maintenance',
            'mobile' => $this->orderInfo->sender->mobile,
            'email' => $this->orderInfo->sender->email,
            
            'maintenance_office_name' => $this->maintenanceOffice->name,
            'price' => $this->price,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_QUOTATION,$params,$estate_office_id);
    }


    public function eventOrderClose($event){
        $estate_office_id = ($this->orderInfo->estate_office_id)? :null;

        $params = [
            're_id' => $this->orderInfo->sender->id ,
            're_type' => $this->orderInfo->sender_type ,
            'content' => 'Close Your Maintenance Order' ,
            'id' => $this->id,
            't_name' => 'order-maintenance',
            'mobile' => $this->orderInfo->sender->mobile,
            'email' => $this->orderInfo->sender->email,
            
            'maintenance_office_name' => $this->maintenanceOffice->name,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_ORDER_CLOSE,$params,$estate_office_id);
    }

    public function eventOrderReplay($event){
        $estate_office_id = ($this->orderInfo->estate_office_id)? :null;
        $params = [
            're_id' => $this->orderInfo->sender->id ,
            're_type' => $this->orderInfo->sender_type ,
            'content' => 'Replay to Maintenance Order' ,
            'id' => $this->id,
            't_name' => 'order-maintenance',
            'mobile' => $this->orderInfo->sender->mobile,
            'email' => $this->orderInfo->sender->email,
            
            'maintenance_office_name' => $this->maintenanceOffice->name,
            'note' => $this->note,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_ORDER_REPLAY,$params,$estate_office_id);
    }

}
