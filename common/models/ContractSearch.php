<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contract;
use yii;
/**
 * ContractSearch represents the model behind the search form of `common\models\Contract`.
 */
class ContractSearch extends Contract
{
    use FilterDate;

    public $estate_office_name;
    public $owner_name;
    public $renter_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'owner_id', 'building_id', 'housing_unit_id', 'renter_id', 'rent_period_id', 'housing_using_type_id', 'contract_form_id', 'user_created_id', 'refrence_contract_id', 'include_water', 'include_electricity', 'include_maintenance', 'status', 'is_active', 'is_draft', 'number_installments'], 'integer'],
            [['contract_no', 'contract_info_json', 'created_date', 'start_date', 'end_date', 'price_text', 'details','estate_office_name','owner_name','renter_name'], 'safe'],
            [['price', 'added_tax', 'insurance_amount'], 'number'],
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
        $query = Contract::find();
        $query->joinWith(['estateOffice','renter as renter_rel','owner as owner_rel'],false);


        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
            case 'owner':
                $andFilter = [
                    'owner_id' => $user->id
                ];
                break;
            case 'renter':
                $andFilter = [
                    'renter_id' => $user->id
                ];
                break;
            case 'estate_officer':
                $query->withDraft()->currentOffice();
                break;
            
            default:
                # code...
                break;
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
        $query->andFilterWhere($andFilter);

        // grid filtering conditions
        $query->andFilterWhere([
            'contract.id' => $this->id,
            'estate_office_id' => $this->estate_office_id,
            'owner_id' => $this->owner_id,
            'building_id' => $this->building_id,
            'housing_unit_id' => $this->housing_unit_id,
            'renter_id' => $this->renter_id,
            'rent_period_id' => $this->rent_period_id,
            'housing_using_type_id' => $this->housing_using_type_id,
            'contract_form_id' => $this->contract_form_id,
            'user_created_id' => $this->user_created_id,
            'refrence_contract_id' => $this->refrence_contract_id,
            'created_date' => $this->created_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price' => $this->price,
            'added_tax' => $this->added_tax,
            'insurance_amount' => $this->insurance_amount,
            'include_water' => $this->include_water,
            'include_electricity' => $this->include_electricity,
            'include_maintenance' => $this->include_maintenance,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'is_draft' => $this->is_draft,
            'number_installments' => $this->number_installments,
        ]);

        $query->andFilterWhere(['like', 'contract_no', $this->contract_no])
            ->andFilterWhere(['like', 'contract_info_json', $this->contract_info_json])
            ->andFilterWhere(['like', 'price_text', $this->price_text])
            ->andFilterWhere(['like', 'estate_office.name', $this->estate_office_name])
            ->andFilterWhere(['like', 'owner_rel.name', $this->owner_name])
            ->andFilterWhere(['like', 'renter_rel.name', $this->renter_name])
            ->andFilterWhere(['like', 'details', $this->details]);

        $this->filterByDate($query,'created_date');
        

        return $dataProvider;
    }
}
