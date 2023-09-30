<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogMessage;

/**
 * LogMessageSearch represents the model behind the search form of `common\models\LogMessage`.
 */
class LogMessageSearch extends LogMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'notif_temp_id', 'receiver_id'], 'integer'],
            [['sender_type', 'receiver_type', 'contact_mobile', 'contact_email', 'message', 'status', 'created_date'], 'safe'],
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
        $query = LogMessage::find();

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
            'notif_temp_id' => $this->notif_temp_id,
            'receiver_id' => $this->receiver_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'sender_type', $this->sender_type])
            ->andFilterWhere(['like', 'receiver_type', $this->receiver_type])
            ->andFilterWhere(['like', 'contact_mobile', $this->contact_mobile])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
