<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan_item".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property int $plan_id
 * @property int $sort_at
 *
 * @property Plan $plan
 */
class PlanItem extends \yii\db\ActiveRecord
{

    public $_title;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_en', 'sort_at'], 'required'],
            [['plan_id', 'sort_at'], 'integer'],
            [['title', 'title_en'], 'string', 'max' => 250],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['plan_id' => 'id']],
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
            'plan_id' => Yii::t('app', 'Plan ID'),
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

    /**
     * Gets query for [[Plan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::class, ['id' => 'plan_id']);
    }
}
