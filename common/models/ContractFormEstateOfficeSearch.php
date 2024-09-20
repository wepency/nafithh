<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ContractFormEstateOffice;

/**
 * ContractFormEstateOfficeSearch represents the model behind the search form of `common\models\ContractFormEstateOffice`.
 */
class ContractFormEstateOfficeSearch extends ContractFormEstateOffice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'contract_form_id', 'status'], 'integer'],
            [['contract_form_name', 'contract_form_name_en', 'contract_form_text', 'contract_form_text_en'], 'safe'],
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
            $query = ContractFormEstateOffice::find()->where(['estate_office_id'=>$estate_office_id]);
        }else{
            $query = ContractFormEstateOffice::find();
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
            'estate_office_id' => $this->estate_office_id,
            'contract_form_id' => $this->contract_form_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'contract_form_name', $this->contract_form_name])
            ->andFilterWhere(['like', 'contract_form_name_en', $this->contract_form_name_en])
            ->andFilterWhere(['like', 'contract_form_text', $this->contract_form_text])
            ->andFilterWhere(['like', 'contract_form_text_en', $this->contract_form_text_en]);

        return $dataProvider;
    }
}
