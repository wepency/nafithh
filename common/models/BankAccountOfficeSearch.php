<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BankAccountOffice;

/**
 * BankAccountOfficeSearch represents the model behind the search form of `common\models\BankAccountOffice`.
 */
class BankAccountOfficeSearch extends BankAccountOffice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estate_office_id', 'status'], 'integer'],
            [['bank_name', 'bank_name_en', 'logo', 'account_number', 'owner_account_name', 'owner_account_name_en', 'iban'], 'safe'],
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
		$session = Yii::$app->session;
		if (isset($session['estate_office_id'])){
			$query = BankAccountOffice::find()->where(['estate_office_id'=>$session['estate_office_id']]);
		}else{
			$query = BankAccountOffice::find();
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'estate_office_id' => $this->estate_office_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_name_en', $this->bank_name_en])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'owner_account_name', $this->owner_account_name])
            ->andFilterWhere(['like', 'owner_account_name_en', $this->owner_account_name_en])
            ->andFilterWhere(['like', 'iban', $this->iban]);

        return $dataProvider;
    }
}
