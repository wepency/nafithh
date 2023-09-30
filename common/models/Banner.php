<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $text
 * @property string $text_en
 * @property string $url
 * @property string $image
 * @property int $status
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $_title;
    public $_text;
    
    public static function tableName()
    {
        return 'banner';
    }
     public function behaviors()
    {
        return [
            'uploadBehavior' => [ 
                'class' =>\common\behaviors\UploadBehavior::class, 
                'fileAttribute' => 'image',
                'saveDir' => Yii::getAlias("@upload/".$this->tableName()."/")
            ],
            
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['text', 'text_en'], 'string'],
            [['status'], 'integer'],
            [['title', 'title_en', 'url', 'image'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 3000 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'Title En'),
            'text' => Yii::t('app', 'Text'),
            'text_en' => Yii::t('app', 'Text En'),
            'url' => Yii::t('app', 'Url'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
     public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_title = $this->title;
            $this->_text = $this->text;
        }else{
            $this->_title = $this->title_en;
            $this->_text = $this->text_en;
        }
    }
}
