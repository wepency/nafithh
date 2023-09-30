<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SettingEstateOffice;

/**
 * SettingEstateOfficeSearch represents the model behind the search form of `common\models\SettingEstateOffice`.
 */
class SettingEstateOfficeSearch extends SettingEstateOffice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'days_before_noti_merit'], 'integer'],
            [['citys', 'nationalities', 'identities', 'building_types', 'housing_unit_types', 'housing_using_types', 'rent_period'], 'safe'],
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
        $query = SettingEstateOffice::find();

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
            'estate_office_id' => $this->estate_office_id,
            'days_before_noti_merit' => $this->days_before_noti_merit,
        ]);

        $query->andFilterWhere(['like', 'citys', $this->citys])
            ->andFilterWhere(['like', 'nationalities', $this->nationalities])
            ->andFilterWhere(['like', 'identities', $this->identities])
            ->andFilterWhere(['like', 'building_types', $this->building_types])
            ->andFilterWhere(['like', 'housing_unit_types', $this->housing_unit_types])
            ->andFilterWhere(['like', 'housing_using_types', $this->housing_using_types])
            ->andFilterWhere(['like', 'rent_period', $this->rent_period]);

        return $dataProvider;
    }
}
