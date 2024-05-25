<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $image
 * @property int $period
 * @property int $currency
 * @property string $price
 * @property int $status
 * @property string $created_date
 * @property int $views
 *
 * @property Order[] $orders
 * @property PlanItem[] $planItems
 */
class Plan extends \yii\db\ActiveRecord
{

    public $_title;
    public $_plan_for;

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
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_en', 'period', 'currency', 'status', 'contracts', 'sms', 'price'], 'required'],
            [['period', 'currency', 'status', 'views'], 'integer'],
            [['created_date'], 'safe'],
            [['sort_at'], 'integer'],

            [['title', 'title_en', 'image'], 'string', 'max' => 255],
            [['price'], 'string', 'max' => 20],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif,bmp', 'maxSize' => 50000 * 1024],

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
            'image' => Yii::t('app', 'Image'),
            'period' => Yii::t('app', 'Plan Period'),
            'currency' => Yii::t('app', 'Currency'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'views' => Yii::t('app', 'Views'),
            'sort_at' => Yii::t('app', 'Sort At'),
            
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

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            PlanItem::deleteAll(['plan_id'=>$this->id]);
            return true;
        } 
        return false;
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['plan_id' => 'id']);
    }

    /**
     * Gets query for [[PlanItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlanItems()
    {
        return $this->hasMany(PlanItem::class, ['plan_id' => 'id'])->orderBy(["sort_at" =>SORT_ASC]);
    }

    public static function getPlanName()
    {
        $droptions = Plan::find()->asArray()->all();
        return (Yii::$app->language=='ar') ? ArrayHelper::map($droptions, 'id', 'title') : ArrayHelper::map($droptions, 'id', 'title_en');
    }
}
