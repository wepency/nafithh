<?php

namespace common\models;
use yii\helpers\Arrayhelper;

use Yii;

/**
 * This is the model class for table "vol_district".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $city_id
 *
 * @property VolRegion $region
 */
class District extends \yii\db\ActiveRecord
{

    public $_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'name', 'name_en', 'city_id', 'status'], 'required'],
            [['status'], 'integer'],
            [['id', 'city_id'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 50],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
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
             '_name' => Yii::t('app', 'District'),
            'status' => Yii::t('app', 'Status'),
             
            'city_id' => Yii::t('app', 'City'),
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
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public static function ListDistrictByCar($city=0)
    {
		if (!empty($city) && $city!=0)
			$droptions = District::find()->where(['city_id'=>$city,'status'=>1])->asArray()->all();
		else
			$droptions = District::find()->where(['status'=>1])->asArray()->all();

        return (Yii::$app->language=='ar') ? Arrayhelper::map($droptions, 'id', 'name') : Arrayhelper::map($droptions, 'id', 'name_en');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

}
