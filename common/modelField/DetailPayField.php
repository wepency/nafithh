<?php

namespace common\modelField;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "storage_place".
 *
 * @property string $name
 * @property string $value
 *
 */
class DetailPayField extends Model
// class SocialField extends \yii\db\ActiveRecord
{
    public $amount;
    public $sender_name;
   
    public function rules()
    {
        return [
            [['amount', 'sender_name'], 'required'],
            [['amount', 'sender_name'], 'string', 'max' => 200],
        ];
    }

    function __toString()
    {
        return \yii\helpers\Json::encode($this);
    }

    public function hasAttribute($attribute)
    {
        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'amount' => Yii::t('app', 'Amount'),
            'sender_name' => Yii::t('app', 'Sender Name'),
        ];
    }

}
