<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Setting1;

/**
 * Setting1Search represents the model behind the search form of `common\models\Setting1`.
 */
class SettingSearch extends Setting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visit_number', 'contract_default_no', 'contract_default_period', 'contract_maintenance_free_no', 'contract_maintenance_free_period', 'enable_installment_deposit_bank', 'enable_installment_cash', 'enable_installment_pay_card', 'enable_installment_network'], 'integer'],
            [['slug', 'slug_en', 'site_name', 'site_name_en', 'description', 'description_en', 'address', 'address_en', 'mobile', 'phone', 'email_admin', 'email', 'facebook', 'twitter', 'youtube', 'linkedin', 'instagram', 'lang', 'lat', 'profile', 'profile_en', 'tax_number', 'services_text', 'services_text_en', 'partners_text', 'partners_text_en', 'key_words', 'key_google_map', 'admin_theme', 'copyright', 'copyright_en', 'about_image', 'logo', 'icon'], 'safe'],
            [['tax_percent_maintenance_order', 'added_tax'], 'number'],
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
        $query = Setting::find();

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
            'visit_number' => $this->visit_number,
            'tax_percent_maintenance_order' => $this->tax_percent_maintenance_order,
            'added_tax' => $this->added_tax,
            'contract_default_no' => $this->contract_default_no,
            'contract_default_period' => $this->contract_default_period,
            'contract_maintenance_free_no' => $this->contract_maintenance_free_no,
            'contract_maintenance_free_period' => $this->contract_maintenance_free_period,
            'enable_installment_deposit_bank' => $this->enable_installment_deposit_bank,
            'enable_installment_cash' => $this->enable_installment_cash,
            'enable_installment_pay_card' => $this->enable_installment_pay_card,
            'enable_installment_network' => $this->enable_installment_network,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'slug_en', $this->slug_en])
            ->andFilterWhere(['like', 'site_name', $this->site_name])
            ->andFilterWhere(['like', 'site_name_en', $this->site_name_en])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_en', $this->address_en])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email_admin', $this->email_admin])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'profile_en', $this->profile_en])
            ->andFilterWhere(['like', 'tax_number', $this->tax_number])
            ->andFilterWhere(['like', 'services_text', $this->services_text])
            ->andFilterWhere(['like', 'services_text_en', $this->services_text_en])
            ->andFilterWhere(['like', 'partners_text', $this->partners_text])
            ->andFilterWhere(['like', 'partners_text_en', $this->partners_text_en])
            ->andFilterWhere(['like', 'key_words', $this->key_words])
            ->andFilterWhere(['like', 'key_google_map', $this->key_google_map])
            ->andFilterWhere(['like', 'admin_theme', $this->admin_theme])
            ->andFilterWhere(['like', 'copyright', $this->copyright])
            ->andFilterWhere(['like', 'copyright_en', $this->copyright_en])
            ->andFilterWhere(['like', 'about_image', $this->about_image])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'icon', $this->icon]);

        return $dataProvider;
    }
}
