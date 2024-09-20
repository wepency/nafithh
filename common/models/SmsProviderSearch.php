<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SmsProvider;

/**
 * SmsProviderSearch represents the model behind the search form of `common\models\SmsProvider`.
 */
class SmsProviderSearch extends SmsProvider
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'paypal_type', 'sending_status'], 'integer'],
            [['domain', 'username', 'password', 'sender', 'sendgrid_username', 'sendgrid_password', 'sandbox', 'production'], 'safe'],
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
        $query = SmsProvider::find();

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
            'paypal_type' => $this->paypal_type,
            'sending_status' => $this->sending_status,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'sender', $this->sender])
            ->andFilterWhere(['like', 'sendgrid_username', $this->sendgrid_username])
            ->andFilterWhere(['like', 'sendgrid_password', $this->sendgrid_password])
            ->andFilterWhere(['like', 'sandbox', $this->sandbox])
            ->andFilterWhere(['like', 'production', $this->production]);

        return $dataProvider;
    }
}
