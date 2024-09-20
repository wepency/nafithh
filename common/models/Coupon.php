<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Coupon extends ActiveRecord
{

    public static function tableName()
    {
        return 'coupons';
    }

    public function rules()
    {
        return [
            [['coupon', 'discount'], 'required'],
            [['discount'], 'number', 'min' => 0, 'max' => 100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'coupon' => \Yii::t('app', 'Coupon'),
            'discount' => \Yii::t('app', 'discount')
        ];
    }

    public function search($params, $query = null)
    {

        if (is_null($query)){
            $query = self::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'page_name' => $this->page_name,
//            'status' => $this->status,
//        ]);

        $query->andFilterWhere(['like', 'coupon', $this->coupon]);

        return $dataProvider;
    }

    public function getCount()
    {
        return Coupon::find()->count();
    }

    public function getCouponUses()
    {
        return $this->hasMany(CouponUses::class, ['coupon_id' => 'id']);
    }
}