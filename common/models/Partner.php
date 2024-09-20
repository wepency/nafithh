<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $url
 * @property string $image
 * @property int $status
 */
class Partner extends \yii\db\ActiveRecord
{
	
	 public $_title;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }
	
	public function behaviors()
    {
        return [
            'uploadBehavior' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'image',
                'saveDir' => Yii::getAlias("@upload/partner/")
            ],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_en', 'url', 'status'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['title_en', 'url', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Name'),
            'title_en' => Yii::t('app', 'Name En'),
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
        }else{
            $this->_title = $this->title_en;
        }
    }
}
