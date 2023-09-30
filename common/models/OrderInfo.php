<?php

namespace common\models;

use Yii;
use common\components\GeneralHelpers;

/**
 * This is the model class for table "order_info".
 *
 * @property int $id
 * @property int $maintenance_type_id
 * @property int $estate_office_id
 * @property int $building_housing_unit_id
 * @property int|null $sender_id {owner_id - renter_id}
 * @property string $sender_type {owner - renter - estate_officer}
 * @property string $send_to {maintenance_officer - estate_officer}
 * @property string $title
 * @property string|null $details_order
 * @property int $is_draft
 * @property string|null $created_date
 *
 * @property BuildingHousingUnit $buildingHousingUnit
 * @property EstateOffice $estateOffice
 * @property MaintenanceType $maintenanceType
 * @property User $sender
 * @property OrderMaintenance[] $orderMaintenances
 */
/*إذا قام المستأجر أو المالك بإرسال الطلب إلى مكتب العقار
فستكون  نوع المرسل هو المالك حتى يقوم المكتب بمراجعة الطلب وإرسالة فستيغر نوع المرسل إلى مكت العقار
ويختفي الطلب من المستأجر أو المالك
إذا قام المستأجر أو المالك بإرسال الطلب إلى مكتب الصيانة
فسيكون نوع المرسل هو مالك أو مستأجر ولن يظهر الطلب لدى المكتب إلا إذا قام المستأجر بتعديل الطلب وتغيير */

class OrderInfo extends \yii\db\ActiveRecord
{
    public $maintenanceOffice;
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
        return 'order_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maintenance_type_id','maintenanceOffice', 'building_housing_unit_id', 'send_to', 'title'], 'required'],
            [['maintenance_type_id', 'estate_office_id', 'building_housing_unit_id', 'sender_id', 'is_draft'], 'integer'],
            [['details_order'], 'string'],
            [['created_date'], 'safe'],
            [['sender_type', 'send_to'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 200],
            [['building_housing_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingHousingUnit::class, 'targetAttribute' => ['building_housing_unit_id' => 'id']],
            [['estate_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstateOffice::class, 'targetAttribute' => ['estate_office_id' => 'id']],
            [['maintenance_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaintenanceType::class, 'targetAttribute' => ['maintenance_type_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],

            [['maintenanceOffice'], 'each', 'rule' => ['integer'], 'skipOnError' => true],

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
            'maintenance_type_id' => Yii::t('app', 'Maintenance Type'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'building_housing_unit_id' => Yii::t('app', 'Building Housing Unit'),
            'sender_id' => Yii::t('app', 'Sender'),
            'sender_type' => Yii::t('app', 'Sender Type'),
            'send_to' => Yii::t('app', 'Send To'),
            'title' => Yii::t('app', 'Title'),
            'maintenanceOffices' => Yii::t('app', 'maintenance Office'),
            'details_order' => Yii::t('app', 'Details Order'),
            'is_draft' => Yii::t('app', 'Is Draft'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
          $result = ($this->orderMaintenances)? 'Order Maintenances': null;  
          if($result !== null){
            Yii::$app->session->setFlash('danger',
              yii::t('app','cannot delete {item} has items from {items}.',[
                'item' =>yii::t('app','Order Info') ,'items' => yii::t('app',$result)
              ])
            );
            return false;
          }

            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
            Attachment::deleteAll(['item_id'=>$this->id , 'item_type' => $this->tableName() ]);
            GeneralHelpers::deleteImagesByPostId($this::class,$this->id);
          return true;
        } 
        return false;
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
     * Gets query for [[EstateOffice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }

    /**
     * Gets query for [[MaintenanceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceType()
    {
        return $this->hasOne(MaintenanceType::class, ['id' => 'maintenance_type_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
         return (in_array($this->sender_type, ['owner','renter'])) ? $this->hasOne(User::class, ['id' => 'sender_id']) : $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }

    /**
     * Gets query for [[OrderMaintenances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderMaintenances()
    {
        return $this->hasMany(OrderMaintenance::class, ['order_info_id' => 'id']);
    }
}
