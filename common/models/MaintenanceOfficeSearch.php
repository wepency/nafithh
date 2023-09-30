<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MaintenanceOffice;

/**
 * MaintenanceOfficeSearch represents the model behind the search form of `common\models\MaintenanceOffice`.
 */
class MaintenanceOfficeSearch extends MaintenanceOffice
{
    use FilterDate;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_account', 'city_id', 'district_id', 'user_created_id', 'tax'], 'integer'],
            [['name', 'logo', 'registration_code', 'auth_person', 'mobile', 'phone', 'email', 'registration_date', 'expire_date', 'description', 'lang', 'lat', 'header_report_image', 'footer_report_image', 'tax_num'], 'safe'],
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
        $query = MaintenanceOffice::find();

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
            'registration_date' => $this->registration_date,
            'expire_date' => $this->expire_date,
            'status_account' => $this->status_account,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'user_created_id' => $this->user_created_id,
            'tax' => $this->tax,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'registration_code', $this->registration_code])
            ->andFilterWhere(['like', 'auth_person', $this->auth_person])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'header_report_image', $this->header_report_image])
            ->andFilterWhere(['like', 'footer_report_image', $this->footer_report_image])
            ->andFilterWhere(['like', 'tax_num', $this->tax_num]);
            
            $this->filterByDate($query,'registration_date');

        return $dataProvider;
    }
}
