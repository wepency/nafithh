<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estate_office_renter".
 *
 * @property int $renter_id
 * @property int $estate_office_id
 */
class EstateOfficeRenter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estate_office_renter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['renter_id', 'estate_office_id'], 'required'],
            [['renter_id', 'estate_office_id'], 'integer'],
            [['renter_id', 'estate_office_id'], 'unique', 'targetAttribute' => ['renter_id', 'estate_office_id'], 'message'=>yii::t('app','has already been taken')],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'renter_id' => Yii::t('app', 'Renter ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
        ];
    }
}
