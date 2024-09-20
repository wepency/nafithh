<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "housing_using_type".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $status
 */
class HousingUsingType extends \yii\db\ActiveRecord
{
    public $_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'housing_using_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'status'], 'required'],
            [['status'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 70],
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
            'name_en' => Yii::t('app', 'Name En'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_name = $this->name;
        }else{
            $this->_name = $this->name_en;
        }
    }
}
