<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_estate_office".
 *
 * @property int $user_id
 * @property int $estate_office_id
 */
class UserEstateOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_estate_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'estate_office_id'], 'required'],
            [['user_id', 'estate_office_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
        ];
    }
}
