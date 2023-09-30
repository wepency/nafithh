<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "maintenance_invoice".
 *
 * @property int $id
 * @property string $date_from
 * @property string $date_to
 * @property float $total_amount
 * @property int $commission_percent
 * @property float $commission_amount
 * @property float $office_earnings
 * @property int|null $office_id
 * @property int|null $user_created_id
 * @property int $payment_status
 * @property string $created_at
 */
class MaintenanceInvoice extends \yii\db\ActiveRecord
{
    const STATUS_NOTPAID = 0;
    const STATUS_PAIDED = 1;
    public $maintenanceOffice;


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
    public static function tableName()
    {
        return 'maintenance_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', 'created_at'], 'safe'],
            [['maintenanceOffice'], 'required'],
            [['total_amount', 'commission_amount', 'office_earnings'], 'number'],
            [['total_amount', 'commission_amount', 'office_earnings','commission_percent'], 'default', 'value' => 0],
            [['commission_percent', 'office_id', 'user_created_id', 'payment_status'], 'integer'],
            [['user_created_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_created_id' => 'id']],
            [['maintenanceOffice'], 'each', 'rule' => ['integer'], 'skipOnError' => true],

            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaintenanceOffice::class, 'targetAttribute' => ['office_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date_from' => Yii::t('app', 'From Date'),
            'date_to' => Yii::t('app', 'To Date'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'commission_percent' => Yii::t('app', 'Commission Percent'),
            'commission_amount' => Yii::t('app', 'Commission Amount'),
            'office_earnings' => Yii::t('app', 'Office Earnings'),
            'office_id' => Yii::t('app', 'Maintenance Office'),
            'maintenanceOffice' => Yii::t('app', 'Maintenance Office'),
            'user_created_id' => Yii::t('app', 'User Created'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }

    public function getOffice()
    {
        return $this->hasOne(MaintenanceOffice::class, ['id' => 'office_id']);
    }


    
}
