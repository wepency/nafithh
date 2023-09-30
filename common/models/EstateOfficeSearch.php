<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EstateOffice;

/**
 * EstateOfficeSearch represents the model behind the search form of `common\models\EstateOffice`.
 */
class EstateOfficeSearch extends EstateOffice
{
    use FilterDate;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_account', 'sms_balance', 'contract_balance', 'city_id', 'district_id'], 'integer'],
            [['name', 'logo', 'registration_code', 'auth_person', 'mobile', 'phone', 'email', 'registration_date', 'expire_date', 'sender_name', 'description', 'lang', 'lat', 'header_report_image', 'footer_report_image', 'notification_method', 'tax_num'], 'safe'],
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
        $query = EstateOffice::find();

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
            'estate_office.id' => $this->id,
            'estate_office.registration_date' => $this->registration_date,
            'estate_office.expire_date' => $this->expire_date,
            'estate_office.status_account' => $this->status_account,
            'estate_office.sms_balance' => $this->sms_balance,
            'estate_office.contract_balance' => $this->contract_balance,
            'estate_office.city_id' => $this->city_id,
            'estate_office.district_id' => $this->district_id,
        ]);

        $query->andFilterWhere(['like', 'estate_office.name', $this->name])
            ->andFilterWhere(['like', 'estate_office.logo', $this->logo])
            ->andFilterWhere(['like', 'estate_office.registration_code', $this->registration_code])
            ->andFilterWhere(['like', 'estate_office.auth_person', $this->auth_person])
            ->andFilterWhere(['like', 'estate_office.mobile', $this->mobile])
            ->andFilterWhere(['like', 'estate_office.phone', $this->phone])
            ->andFilterWhere(['like', 'estate_office.email', $this->email])
            ->andFilterWhere(['like', 'estate_office.description', $this->description])
            ->andFilterWhere(['like', 'estate_office.lang', $this->lang])
            ->andFilterWhere(['like', 'estate_office.lat', $this->lat])
            ->andFilterWhere(['like', 'estate_office.header_report_image', $this->header_report_image])
            ->andFilterWhere(['like', 'estate_office.footer_report_image', $this->footer_report_image])
            ->andFilterWhere(['like', 'estate_office.notification_method', $this->notification_method])
            ->andFilterWhere(['like', 'estate_office.tax_num', $this->tax_num]);
            
            $this->filterByDate($query,'registration_date');

        return $dataProvider;
    }
}
