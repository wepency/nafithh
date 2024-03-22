<?php

namespace common\models;

use yii\db\ActiveRecord;

class Coupon extends ActiveRecord
{

    public static function tableName()
    {
        return 'coupons';
    }
}