<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estate_office_owner".
 *
 * @property int $owner_id
 * @property int $estate_office_id
 */
class EstateOfficeOwner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estate_office_owner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id', 'estate_office_id'], 'required'],
            [['owner_id', 'estate_office_id'], 'integer'],
            [['owner_id', 'estate_office_id'], 'unique', 'targetAttribute' => ['owner_id', 'estate_office_id'], 'message'=>yii::t('app','has already been taken')],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'owner_id' => Yii::t('app', 'Owner ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
        ];
    }
}
