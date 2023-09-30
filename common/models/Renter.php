<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "renter".
 *
 * @property int $id
 * @property string $identity_id
 * @property int $identity_type_id
 * @property int $user_id
 * @property string $name
 * @property string|null $work_name
 * @property string|null $work_address
 * @property string|null $work_phone
 * @property string|null $description
 * @property int $status
 */
class Renter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'renter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['identity_id', 'identity_type_id', 'user_id', 'name'], 'required'],
            [['identity_type_id', 'user_id', 'status'], 'integer'],
            ['user_id', 'unique'],
            [['identity_id', 'work_phone'], 'string', 'max' => 50],
            [['name', 'work_name'], 'string', 'max' => 100],
            [['work_address'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 700],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'identity_id' => Yii::t('app', 'Identity ID'),
            'identity_type_id' => Yii::t('app', 'Identity Type ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'work_name' => Yii::t('app', 'Work Name'),
            'work_address' => Yii::t('app', 'Work Address'),
            'work_phone' => Yii::t('app', 'Work Phone'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
