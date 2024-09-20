<?php

namespace common\models;

use Yii;
use common\components\GeneralHelpers;

/**
 * This is the model class for table "balance_sms".
 *
 * @property int $id
 * @property int $estate_office_id
 * @property int $user_id
 * @property int $amount
 * @property float $price
 * @property string $created_at
 */
class BalanceSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estate_office_id', 'amount', 'price', 'expire_date'], 'required'],
            [['estate_office_id', 'user_id', 'amount'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'user_id', 'expire_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'user_id' => Yii::t('app', 'User Name'),
            'amount' => Yii::t('app', 'Number Messages'),
            'price' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Created At'),
            'expire_date' => Yii::t('app', 'Expire Sms Date'),

        ];
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
	
	public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            GeneralHelpers::balanceChange($this,'delete');
            return true;
        } else {
            return false;
        }
    }
}
