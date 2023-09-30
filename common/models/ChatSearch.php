<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Chat;

/**
 * ChatSearch represents the model behind the search form of `common\models\Chat`.
 */
class ChatSearch extends Chat
{
    use FilterDate;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'receiver_id'], 'integer'],
            [['sender_type', 'receiver_type', 'title', 'created_at'], 'safe'],
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
        $query = Chat::find();

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
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'sender_type', $this->sender_type])
            ->andFilterWhere(['like', 'receiver_type', $this->receiver_type])
            ->andFilterWhere(['like', 'title', $this->title]);

        $this->filterByDate($query);

        return $dataProvider;
    }
}
