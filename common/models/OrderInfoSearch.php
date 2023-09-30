<?php

namespace common\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderInfo;

/**
 * OrderInfoSearch represents the model behind the search form of `common\models\OrderInfo`.
 */
class OrderInfoSearch extends OrderInfo
{
    use FilterDate;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'maintenance_type_id', 'estate_office_id', 'building_housing_unit_id', 'sender_id', 'is_draft'], 'integer'],
            [['sender_type', 'send_to', 'title', 'details_order', 'created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrderInfo::find();


        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
            case 'owner':
            case 'renter':
                $andFilter = [
                    'sender_id' => $user->id,
                    'sender_type' => $user->user_type
                ];
                break;
            case 'estate_officer':
                $query->where(['estate_office_id' => \common\components\GeneralHelpers::getEstateOfficeId()]);
                $andFilter = 
                    ['Or',['sender_type'=> 'estate_officer'],['send_to'=> 'estate_officer']];
                break;
            
            default:
                # code...
                break;
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

        $query->andFilterWhere($andFilter);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'maintenance_type_id' => $this->maintenance_type_id,
            'estate_office_id' => $this->estate_office_id,
            'building_housing_unit_id' => $this->building_housing_unit_id,
            'sender_id' => $this->sender_id,
            'is_draft' => $this->is_draft,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'sender_type', $this->sender_type])
            ->andFilterWhere(['like', 'send_to', $this->send_to])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'details_order', $this->details_order]);

            $this->filterByDate($query,'created_date');

        return $dataProvider;
    }
}
