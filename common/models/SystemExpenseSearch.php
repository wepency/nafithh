<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SystemExpense;

/**
 * SystemExpenseSearch represents the model behind the search form of `common\models\SystemExpense`.
 */
class SystemExpenseSearch extends SystemExpense
{
    use FilterDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['item', 'details', 'created_date', 'pay_date'], 'safe'],
            [['amount','user_created_id'], 'number'],
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
        $query = SystemExpense::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'created_date' => $this->created_date,
            'pay_date' => $this->pay_date,
            'user_created_id' => $this->user_created_id,
        ]);

        $query->andFilterWhere(['like', 'item', $this->item])
            ->andFilterWhere(['like', 'details', $this->details]);
             $this->filterByDate($query,'pay_date');

        return $dataProvider;
    }
}
