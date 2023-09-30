<?php

namespace common\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StatementReceiptCatch;

/**
 * StatementReceiptCatchSearch represents the model behind the search form of `common\models\StatementReceiptCatch`.
 */
class StatementReceiptCatchSearch extends StatementReceiptCatch
{
    public $owner_name;
    public $estate_office_name;

    use FilterDate;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'owner_id'], 'integer'],
            [['amount_paid'], 'number'],
            [['detail', 'detail_en', 'created_date','owner_name','estate_office_name'], 'safe'],
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
        $query = StatementReceiptCatch::find();
        $query->joinWith(['owner','estateOffice'],false);

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
            'statement_receipt_catch.id' => $this->id,
            'statement_receipt_catch.amount_paid' => $this->amount_paid,
            'statement_receipt_catch.estate_office_id' => $this->estate_office_id,
            'statement_receipt_catch.owner_id' => $this->owner_id,
            'statement_receipt_catch.created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'statement_receipt_catch.detail', $this->detail])
            ->andFilterWhere(['like', 'user.name', $this->owner_name])
            ->andFilterWhere(['like', 'estate_office.name', $this->estate_office_name])
            ->andFilterWhere(['like', 'statement_receipt_catch.detail_en', $this->detail_en]);
        $this->filterByDate($query,'statement_receipt_catch.created_date');

        return $dataProvider;
    }
}
