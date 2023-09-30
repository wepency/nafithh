<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notification;

/**
 * NotificationSearch represents the model behind the search form of `common\models\Notification`.
 */
class NotificationSearch extends Notification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'receiver_id', 'subject_id', 'status_read'], 'integer'],
            [['notification_type', 'receiver_type', 'content', 'table_name', 'created_at', 'readed_at'], 'safe'],
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
        $query = Notification::find();

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
            'receiver_id' => $this->receiver_id,
            'subject_id' => $this->subject_id,
            'created_at' => $this->created_at,
            'readed_at' => $this->readed_at,
            'status_read' => $this->status_read,
        ]);

        $query->andFilterWhere(['like', 'notification_type', $this->notification_type])
            ->andFilterWhere(['like', 'receiver_type', $this->receiver_type])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'table_name', $this->table_name]);

        return $dataProvider;
    }
}
