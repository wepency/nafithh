<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $body
 * @property string $body_en
 * @property int $status
 */
class Service extends \yii\db\ActiveRecord
{
    public $_name;
    public $_body;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }
   public function behaviors()
    {
        return [
            'uploadBehavior' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'image',
                'saveDir' => Yii::getAlias("@upload/service/")
            ],
            
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'body', 'body_en', 'status'], 'required'],
            [['body', 'body_en'], 'string'],
            [['status'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 150],
            [['image'], 'string', 'max' => 200],
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
            'body' => Yii::t('app', 'Body'),
            'body_en' => Yii::t('app', 'Body En'),
            'status' => Yii::t('app', 'Status'),
            'image' => Yii::t('app', 'Image'),
        ];
    }
    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_name = $this->name;
            $this->_body= $this->body;
        }else{
			$this->_name = $this->name_en;
            $this->_body = $this->body_en;
        }
    }
}
