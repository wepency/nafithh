<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReceiptVoucher;

/**
 * ReceiptVoucherSearch represents the model behind the search form about `common\models\ReceiptVoucher`.
 */
class ReceiptVoucherSearch extends ReceiptVoucher
{
    public $owner_name;
    public $housing_unit_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'estate_office_id', 'building_housing_unit_id', 'maintenance_office_id', 'user_receipt_id'], 'integer'],
            [['recipient_type', 'amount_text', 'receipt_voucher_no', 'pay_against', 'payment_method', 'created_date', 'details','owner_name','housing_unit_name'], 'safe'],
            [['amount'], 'number'],
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
        $query = ReceiptVoucher::find();

        $query->joinWith(['buildingHousingUnit','owner'],false);

        $user = yii::$app->user->identity;
        $andFilter = [];

        switch ($user->role) {
            case 'owner':
                $andFilter = [
                    'owner_id' => $user->id
                ];
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $andFilter = [
                    'estate_office_id' => $estate_office_id
                ];
                break;
            case 'maintenance_officer':
                $maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();
                $andFilter = [
                    'maintenance_office_id' => $maintenance_office_id
                ];
                break;
            default:
                # code...
                break;
        }

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

        $query->andFilterWhere($andFilter);


        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'estate_office_id' => $this->estate_office_id,
            'building_housing_unit_id' => $this->building_housing_unit_id,
            'maintenance_office_id' => $this->maintenance_office_id,
            'amount' => $this->amount,
            'user_receipt_id' => $this->user_receipt_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'recipient_type', $this->recipient_type])
            ->andFilterWhere(['like', 'amount_text', $this->amount_text])
            ->andFilterWhere(['like', 'receipt_voucher_no', $this->receipt_voucher_no])
            ->andFilterWhere(['like', 'pay_against', $this->pay_against])
            ->andFilterWhere(['like', 'user.name', $this->owner_name])
            ->andFilterWhere(['like', 'building_housing_unit.housing_unit_name', $this->housing_unit_name])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
