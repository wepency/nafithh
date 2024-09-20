<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting_estate_office".
 *
 * @property int $id
 * @property int $estate_office_id
 * @property int $days_before_noti_merit
 * @property string|null $citys all selected numbers will add as spareted with comma,
 * @property string|null $nationalities all selected numbers will add as spareted with comma,
 * @property string|null $identities  all selected numbers will add as spareted with comma,
 * @property string|null $building_types  all selected numbers will add as spareted with comma,
 * @property string|null $housing_unit_types  all selected numbers will add as spareted with comma,
 * @property string|null $housing_using_types  all selected numbers will add as spareted with comma,
 * @property string|null $rent_period  all selected numbers will add as spareted with comma,
 */
class SettingEstateOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_estate_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estate_office_id'], 'required'],
            ['estate_office_id', 'unique'],
            [['estate_office_id','days_before_noti_merit'], 'integer'],

            ['days_before_noti_merit', 'default', 'value' => yii::$app->params['daysBeforeNotiMerit']],
            [['citys', 'nationalities', 'identities', 'building_types', 'housing_unit_types', 'housing_using_types', 'rent_period'], 'default', 'value' => ''],

			//[['citys', 'nationalities', 'identities', 'building_types', 'housing_unit_types', 'housing_using_types', 'rent_period'], 'each', 'rule' => ['integer'], 'skipOnError' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
            'days_before_noti_merit' => Yii::t('app', 'days before notification merit'),
            'citys' => Yii::t('app', 'Citys'),
            'nationalities' => Yii::t('app', 'Nationalities'),
            'identities' => Yii::t('app', 'Identities'),
            'building_types' => Yii::t('app', 'Building Types'),
            'housing_unit_types' => Yii::t('app', 'Housing Unit Types'),
            'housing_using_types' => Yii::t('app', 'Housing Using Types'),
            'rent_period' => Yii::t('app', 'Rent Period'),
        ];
    }
}
