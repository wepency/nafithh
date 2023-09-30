<?php

namespace common\components;

use common\models\Setting;
use yii\base\Component;

//use backend\models\SmsProvider;

class SiteSetting extends Component
{
    private $_myData = null;

    public function siteName()
    {
        $query = Setting::find()->select(['site_name_en', 'site_name'])->where('id=1')->One()->_site_name;
        // $query = Setting::findOne(1)->select(['_site_name']);
        return $query;
    }

    public function info()
    {
        if ($this->_myData !== null) return $this->_myData;
        $this->_myData = Setting::findOne(1);
        return $this->info();
    }

    // query Estate Office Setting
    /*
    for used 
    $EOS = yii::$app->SiteSetting->queryEOS();
    $EOS[ attributes in SettingEstateOffice ]->where()->all()
    example : $EOS['building_types']->where()->all()
    
    */
    public function queryEOS()
    {
        $list = [];
        $attrWithClass = [
            'building_types' => \common\models\BuildingType::class,
            'citys' => \common\models\City::class,
            'nationalities' => \common\models\Nationality::class,
            'identities' => \common\models\IdentityType::class,
            // 'housing_unit_types'=> \common\models\HousingUnitType::class,
            'housing_using_types' => \common\models\HousingUsingType::class,
            'rent_period' => \common\models\RentPeriod::class,
        ];
        foreach ($attrWithClass as $attr => $class) {

            $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
            $query = $class::find();

            if ($estate_office_id) {
                $estateOffice = \common\models\SettingEstateOffice::find()->where(['estate_office_id' => $estate_office_id])->one();
                if ($estateOffice) {
                    $ids = ($estateOffice->$attr) ? explode(',', $estateOffice->$attr) : '';
                    $query->AndOnCondition(['id' => $ids]);
                }
            }

            $list[$attr] = $query->AndOnCondition(['status' => 1]);
        }

        return $list;
    }

}