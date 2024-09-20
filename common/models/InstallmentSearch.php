<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * InstallmentSearch represents the model behind the search form of `common\models\Installment`.
 */
class InstallmentSearch extends Installment
{
    use FilterDate;

    public $identity;
    public $renter_mobile;
    public $contract_no;
    // public $building_name;
    public $building_id;
    public $housing_unit_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contract_id', 'renter_id', 'payment_status', 'building_id'], 'integer'],
            [['installment_no', 'amount_text', 'details', 'start_date', 'end_date', 'identity', 'renter_mobile', 'contract_no', 'housing_unit_name'], 'safe'],
            [['amount', 'amount_paid', 'amount_remaining'], 'number'],
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
        $query = Installment::find();
        $query->joinWith(['renter', 'contract', 'contract.building', 'contract.housingUnit'], false);

        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
            case 'owner':
                // $query->joinWith('contract');
                $andFilter = [
                    'contract.owner_id' => $user->id
                ];
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                // $query->joinWith('contract as c');
                $andFilter = [
                    'contract.estate_office_id' => $estate_office_id,
                    // 'contract.i                                                                                                                           bjs_active' => 1
                ];
                break;
            case 'renter':
                $andFilter = [
                    'renter_id' => $user->id
                ];
                break;

            default:
                # code...
                break;
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['payment_status' => SORT_ASC, 'start_date' => SORT_DESC]]
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
            'installment.id' => $this->id,
            'contract_id' => $this->contract_id,
            'installment.renter_id' => $this->renter_id,
            'installment.payment_status' => $this->payment_status,
            'installment.amount' => $this->amount,
            'installment.amount_paid' => $this->amount_paid,
            'installment.amount_remaining' => $this->amount_remaining,
            'installment.start_date' => $this->start_date,
            'building.id' => $this->building_id,
            'end_date' => $this->end_date,
        ]);

        if (Yii::$app->request->get('belated') == 1) {
            $InstaIds = Installment::find()->joinWith(['contract'])->select(['installment.id', 'contract_id'])->where(['contract.estate_office_id' => $estate_office_id])->asArray()->all();
            $InstaIds = ArrayHelper::getColumn($InstaIds, 'id');

            $query->andFilterWhere(['installment.id' => $InstaIds, 'installment.payment_status' => Installment::STATUS_UNPAID])->andFilterWhere(['<', 'installment.start_date', date("Y-m-d")]);
        }

        if (Yii::$app->request->get('type') == "aboutToExpire") {
            $query->andFilterWhere(['installment.payment_status' => [0, 2]])
                ->andFilterWhere(['between', 'installment.end_date', new Expression('CURDATE() + INTERVAL 1 DAY'), new Expression('CURDATE() + INTERVAL 30 DAY')]);
        }

        $query->andFilterWhere(['like', 'installment_no', $this->installment_no])
            ->andFilterWhere(['like', 'user.identity_id', $this->identity])
            ->andFilterWhere(['like', 'user.mobile', $this->renter_mobile])
            ->andFilterWhere(['like', 'amount_text', $this->amount_text])
            ->andFilterWhere(['like', 'contract.contract_no', $this->contract_no])
            // ->andFilterWhere(['like', 'building.building_name', $this->building_name])
            ->andFilterWhere(['like', 'building_housing_unit.housing_unit_name', $this->housing_unit_name])
            ->andFilterWhere(['like', 'details', $this->details]);

        $this->filterByDate($query, 'installment.start_date');
        return $dataProvider;
    }
}
