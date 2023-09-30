<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Statement;

/**
 * StatementSearch represents the model behind the search form about `common\models\Statement`.
 */
class StatementSearch extends Statement
{
    use FilterDate;

    public $housing_ids;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'housing_id', 'building_id', 'reference_id', 'estate_office_id', 'owner_id', 'contract_id'], 'integer'],
            [['debit', 'credit'], 'number'],
            [['type', 'instalment_ids', 'detail', 'detail_en', 'created_date', 'year','housing_ids'], 'safe'],
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
    public function search($params,$owner_id,$estate_office_id)
    {
        $query = Statement::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             // 'sort' => ['defaultOrder' => ['id' => SORT_DESC]]

        ]);

        $and = [
            'statement.owner_id' => $owner_id,
            'statement.estate_office_id' => $estate_office_id
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere($and);


        $query->andFilterWhere([
            'statement.id' => $this->id,
            'statement.housing_id' => $this->housing_id,
            'statement.building_id' => $this->building_id,
            'statement.debit' => $this->debit,
            'statement.credit' => $this->credit,
            'statement.reference_id' => $this->reference_id,
            'statement.estate_office_id' => $this->estate_office_id,
            'statement.owner_id' => $this->owner_id,
            'statement.contract_id' => $this->contract_id,
            // 'created_date' => $this->created_date,
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'statement.type', $this->type])
            ->andFilterWhere(['like', 'statement.instalment_ids', $this->instalment_ids])
            ->andFilterWhere(['like', 'statement.detail', $this->detail])
            ->andFilterWhere(['in', 'statement.housing_id', $this->housing_ids])
            ->andFilterWhere(['like', 'statement.detail_en', $this->detail_en]);

        $this->filterByDate($query,'statement.created_date');


        return $dataProvider;
    }
}
