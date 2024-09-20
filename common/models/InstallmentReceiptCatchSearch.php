<?php

namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InstallmentReceiptCatch;

/**
 * InstallmentReceiptCatchSearch represents the model behind the search form of `common\models\InstallmentReceiptCatch`.
 */
class InstallmentReceiptCatchSearch extends InstallmentReceiptCatch
{
    use FilterDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'installment_id', 'user_receive_id', 'payment_method', 'payment_status'], 'integer'],
            [['receipt_catch_no', 'details', 'created_date'], 'safe'],
            [['amount_paid', 'amount_remaining'], 'number'],
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
        $query = InstallmentReceiptCatch::find();

        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
            case 'owner':
                $query->joinWith(['installment.contract','installment']);
                $andFilter = [
                    'contract.owner_id' => $user->id
                ];
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $query->joinWith(['installment.contract','installment']); 
                $andFilter = [
                    'contract.estate_office_id' => $estate_office_id,
                    // 'contract.i                                                                                                                           bjs_active' => 1
                ];
                break;
                case 'renter':
                $query->joinWith(['installment']); 

                $andFilter = [
                    'installment.renter_id' => $user->id
                ];
            
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
            'installment_receipt_catch.id' => $this->id,
            'installment_receipt_catch.installment_id' => $this->installment_id,
            'user_receive_id' => $this->user_receive_id,
            'installment_receipt_catch.payment_method' => $this->payment_method,
            'installment_receipt_catch.payment_status' => $this->payment_status,
            'installment_receipt_catch.amount_paid' => $this->amount_paid,
            'installment_receipt_catch.amount_remaining' => $this->amount_remaining,
            'installment_receipt_catch.created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'receipt_catch_no', $this->receipt_catch_no])
            ->andFilterWhere(['like', 'details', $this->details]);
            $this->filterByDate($query,'installment_receipt_catch.created_date');

        return $dataProvider;
    }
}
