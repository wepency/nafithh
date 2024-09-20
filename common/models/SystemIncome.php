<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system_income".
 *
 * @property int $id
 * @property string $item Income Item
 * @property float $amount
 * @property string $details
 * @property string|null $created_date
 * @property string|null $pay_date Income Date
 */
class SystemIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_income';
    }

    public function behaviors()
    {
        return [
            [
            'class' => 'yii\behaviors\BlameableBehavior',
            'attributes' =>
                [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_created_id',
                ],
            'value' => function(){
                return Yii::$app->user->identity->id;
            }
        ], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item', 'amount', 'details'], 'required'],
            [['amount','user_created_id'], 'number'],
            [['details'], 'string'],
            [['created_date', 'pay_date'], 'safe'],
            [['item'], 'string', 'max' => 500],
            [['user_created_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_created_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item' => Yii::t('app', 'Income Item'),
            'amount' => Yii::t('app', 'Amount'),
            'details' => Yii::t('app', 'Details'),
            'created_date' => Yii::t('app', 'Created Date'),
            'pay_date' => Yii::t('app', 'Income Date'),
            'user_created_id' => Yii::t('app', 'User Created'),

        ];
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }
}
