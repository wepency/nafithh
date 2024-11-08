<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MessageSms;

/**
 * MessageSmsSearch represents the model behind the search form of `common\models\MessageSms`.
 */
class MessageSmsSearch extends MessageSms
{
    use FilterDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_created_id'], 'integer'],
            [['message', 'numbers', 'created_date'], 'safe'],
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
        $query = MessageSms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'user_created_id' => $this->user_created_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'numbers', $this->numbers]);
            $this->filterByDate($query,'created_date');
        return $dataProvider;
    }
}
