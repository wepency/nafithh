<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\FilterDate;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{

    public $startDate;
    public $endDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'confirmed','black_list','identity_id','nationality_id'], 'integer'],
            [['username', 'password_hash', 'auth_key', 'password_reset_token', 'email', 'mobile', 'name', 'activation_code', 'avatar', 'description', 'address', 'user_type'], 'safe'],
            [['startDate','endDate'], 'safe'],

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
    public function search($params,$user_type='')
    {
        $query = User::find();
        if($user_type){
            \common\components\MultiUserType::querySearch($user_type,$query);

        }




        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=> ['created_at'=>SORT_DESC]],
        ]);

       

        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'user.confirmed' => $this->confirmed,
            'user.identity_id' => $this->identity_id,
            'user.black_list' => $this->black_list,
            'user.nationality_id' => $this->nationality_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'user_type', $this->user_type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'activation_code', $this->activation_code])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address]);
            
        $startDate = Yii::$app->formatter->asTimestamp($this->startDate.' 00:00:00');
        $endDate = Yii::$app->formatter->asTimestamp($this->endDate.' 23:59:59');
        if($this->startDate && $this->endDate){
        $query->andFilterWhere([ 'AND',
                                    ['>=', 'created_at', $startDate],
                                        ['<=', 'created_at', $endDate]
                                        
                                    ]);
        }elseif($this->startDate){
            $query->andFilterWhere(['>=', 'created_at', $startDate]);
        }elseif($this->endDate){
            $query->andFilterWhere(['<=', 'created_at', $endDate]);
        }else{
            '';
        }
        return $dataProvider;
    }
}
