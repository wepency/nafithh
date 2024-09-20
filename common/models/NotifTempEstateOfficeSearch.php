<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NotifTempEstateOffice;

/**
 * NotifTempEstateOfficeSearch represents the model behind the search form of `common\models\NotifTempEstateOffice`.
 */
class NotifTempEstateOfficeSearch extends NotifTempEstateOffice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'enable_sms', 'enable_email', 'estate_office_id', 'notification_id'], 'integer'],
            [['name', 'name_en', 'title_email', 'title_email_en', 'body_email', 'body_email_en', 'body_sms', 'body_sms_en'], 'safe'],
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
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        if (isset($estate_office_id)){
            $query = NotifTempEstateOffice::find()->where(['estate_office_id'=>$estate_office_id]);
        }else{
            $query = NotifTempEstateOffice::find();
        }

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
            'enable_sms' => $this->enable_sms,
            'enable_email' => $this->enable_email,
            'estate_office_id' => $this->estate_office_id,
            'notification_id' => $this->notification_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'title_email', $this->title_email])
            ->andFilterWhere(['like', 'title_email_en', $this->title_email_en])
            ->andFilterWhere(['like', 'body_email', $this->body_email])
            ->andFilterWhere(['like', 'body_email_en', $this->body_email_en])
            ->andFilterWhere(['like', 'body_sms', $this->body_sms])
            ->andFilterWhere(['like', 'body_sms_en', $this->body_sms_en]);

        return $dataProvider;
    }
}
