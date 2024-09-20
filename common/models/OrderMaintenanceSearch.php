<?php

namespace common\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderMaintenance;

/**
 * OrderMaintenanceSearch represents the model behind the search form of `common\models\OrderMaintenance`.
 */
class OrderMaintenanceSearch extends OrderMaintenance
{
    use FilterDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'maintenance_office_id', 'order_info_id', 'status', 'status_accept'], 'integer'],
            [['note', 'reason_disagree'], 'safe'],
            [['price'], 'number'],
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
        $query = OrderMaintenance::find();

        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
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

        $query->andFilterWhere($andFilter);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'maintenance_office_id' => $this->maintenance_office_id,
            'order_info_id' => $this->order_info_id,
            'price' => $this->price,
            'status' => $this->status,
            'status_accept' => $this->status_accept,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'reason_disagree', $this->reason_disagree]);

           // $this->filterByDate($query,'created_date');
        return $dataProvider;
    }
}
