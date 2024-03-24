<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property int $user_id
 * @property int $coupon_id
 * @property int $order_id
 */
class CouponUses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon_uses';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
