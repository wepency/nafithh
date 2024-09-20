<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $link
 * @property string $image
 * @property string $page_name
 * @property int $status
 */
class Ad extends \yii\db\ActiveRecord
{
	public $_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ad';
    }
	
	public function behaviors()
    {
        return [
            'uploadBehavior' => 
				[ 
					'class' => \common\behaviors\UploadBehavior::class,
					'fileAttribute' => 'image',
					'saveDir' => Yii::getAlias("@upload/ad/")
				], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'status','page_name', 'adLicenseNumber', 'adLicenseId', 'idType'], 'required'],
            [['status'], 'integer'],
            [['name', 'name_en', 'link', 'image'], 'string', 'max' => 255],
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
            'link' => Yii::t('app', 'Link'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
            'page_name' => Yii::t('app', 'View In Page'),
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
