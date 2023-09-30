<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estate_office_building".
 *
 * @property int $building_id
 * @property int $owner_id
 * @property int $estate_office_id
 * @property int $user_id
 * @property string $receive_date
 * @property string $expire_date
 * @property string $updated_at
 * @property int $is_active
 */
class EstateOfficeBuilding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estate_office_building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['building_id', 'owner_id', 'estate_office_id', 'user_id'], 'required'],
            [['building_id', 'owner_id', 'estate_office_id', 'user_id', 'is_active'], 'integer'],
            [['receive_date', 'expire_date', 'updated_at'], 'safe'],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::class, 'targetAttribute' => ['building_id' => 'id']], 
           [['estate_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstateOffice::class, 'targetAttribute' => ['estate_office_id' => 'id']], 
           [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']], 
           [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']], 
            // [['owner_id', 'estate_office_id','building_id','is_active'], 'unique', 'targetAttribute' => ['owner_id', 'estate_office_id','building_id',1=> 'is_active'], 'message'=>yii::t('app','has already been taken')],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'building_id' => Yii::t('app', 'Building ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'receive_date' => Yii::t('app', 'Receive Date'),
            'expire_date' => Yii::t('app', 'Expire Date'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

     /** 
    * Gets query for [[Building]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBuilding() 
   { 
       return $this->hasOne(Building::class, ['id' => 'building_id']); 
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
    * Gets query for [[Owner]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getOwner() 
   { 
       return $this->hasOne(User::class, ['id' => 'owner_id']); 
   } 
 
   /** 
    * Gets query for [[User]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getUser() 
   { 
       return $this->hasOne(User::class, ['id' => 'user_id']); 
   } 
}
