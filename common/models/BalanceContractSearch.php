<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BalanceContract;

/**
 * BalanceContractSearch represents the model behind the search form of `common\models\BalanceContract`.
 */
class BalanceContractSearch extends BalanceContract
{
    use FilterDate;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'user_id', 'amount'], 'integer'],
            [['price'], 'number'],
            [['expire_date', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = BalanceContract::find();

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
            'estate_office_id' => $this->estate_office_id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'price' => $this->price,
            'expire_date' => $this->expire_date,
            'created_at' => $this->created_at,
        ]);

        $this->filterByDate($query,'created_at');

        return $dataProvider;
    }
}
