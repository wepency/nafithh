<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "housing_unit_type".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $status
 */
class HousingUnitType extends \yii\db\ActiveRecord
{
	public $_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'housing_unit_type';
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


    public static function getHousingUnitTypeName()
    {
         $droptions = HousingUnitType::find()->asArray()->all();

        return (Yii::$app->language=='ar') ? ArrayHelper::map($droptions, 'id', 'name') : ArrayHelper::map($droptions, 'id', 'name_en');
    }
}
