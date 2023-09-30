<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_maintenance_office".
 *
 * @property int $user_id
 * @property int $estate_office_id
 */
class UserMaintenanceOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_maintenance_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'maintenance_office_id'], 'required'],
            [['user_id', 'maintenance_office_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'maintenance_office_id' => Yii::t('app', 'Maintenance Office'),
        ];
    }
}
