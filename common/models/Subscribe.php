<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribe".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property int $compony_type
 * @property string $compony_name
 * @property string $message
 */
class Subscribe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'compony_type', 'compony_name', 'message'], 'required'],
            [['compony_type'], 'integer'],
            [['message'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['email', 'compony_name'], 'string', 'max' => 200],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'compony_type' => Yii::t('app', 'Company Type'),
            'compony_name' => Yii::t('app', 'Company Name'),
            'message' => Yii::t('app', 'Message'),
        ];
    }
}
