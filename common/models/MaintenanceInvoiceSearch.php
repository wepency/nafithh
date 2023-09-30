<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MaintenanceInvoice;
use yii;
/**
 * MaintenanceInvoiceSearch represents the model behind the search form of `common\models\MaintenanceInvoice`.
 */
class MaintenanceInvoiceSearch extends MaintenanceInvoice
{
    use FilterDate;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'commission_percent', 'office_id', 'user_created_id', 'payment_status'], 'integer'],
            [['date_from', 'date_to', 'created_at'], 'safe'],
            [['total_amount', 'commission_amount', 'office_earnings'], 'number'],
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
        $query = MaintenanceInvoice::find();
        
        $user = yii::$app->user->identity;
        $andFilter = [];
        switch ($user->role) {
            case 'maintenance_officer':
                $maintenance_office_id = \common\components\GeneralHelpers::getMaintenanceOfficeId();
                $andFilter = [
                    'office_id' => $maintenance_office_id
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
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'total_amount' => $this->total_amount,
            'commission_percent' => $this->commission_percent,
            'commission_amount' => $this->commission_amount,
            'office_earnings' => $this->office_earnings,
            'office_id' => $this->office_id,
            'user_created_id' => $this->user_created_id,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
        ]);
        $this->filterByDate($query,'created_at');
        
        return $dataProvider;
    }
}
