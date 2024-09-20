<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Building;

/**
 * BuildingSearch represents the model behind the search form of `common\models\Building`.
 */
class BuildingSearch extends Building
{
    public $owner_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id', 'status', 'housing_units_available', 'housing_units_rented', 'has_parking', 'ad_status', 'building_age', 'ad_subtype', 'for_rent', 'for_sale', 'for_invest'], 'integer'],
            [['instrument_number', 'building_name', 'lang', 'lat', 'building_status', 'description', 'updated_at', 'annual_income', 'owner_name'], 'safe'],
            [['rent_price', 'sale_price'], 'number'],
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
        $user = yii::$app->user->identity;
        $query = Building::find();
        $query->joinWith('owner', false);

        $andFilter = [];
        switch ($user->role) {
            case 'owner':
                $query->where(['owner_id' => $user->id]);
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $query->joinWith('estateContract');
                $andFilter = [
                    'estate_office_building.estate_office_id' => $estate_office_id,
                    'estate_office_building.is_active' => 1
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

        // grid filtering conditions
        $query->andFilterWhere($andFilter);

        $query->andFilterWhere([
            'building.id' => $this->id,
            'building.owner_id' => $this->owner_id,
            'building_type_id' => $this->building_type_id,
            'floors' => $this->floors,
            'housing_units' => $this->housing_units,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'building.status' => $this->status,
            'building.ad_status' => $this->ad_status,
            'housing_units_available' => $this->housing_units_available,
            'housing_units_rented' => $this->housing_units_rented,
            'building.has_parking' => $this->has_parking,
//            'building.for_rent' => $this->for_rent,
//            'building.for_sale' => $this->for_sale,
//            'building.for_invest' => $this->for_invest,
            'building.rent_price' => $this->rent_price,
            'building.building_age' => $this->building_age,
            'building.sale_price' => $this->sale_price,
            'building.updated_at' => $this->updated_at
        ]);

        // This custom filter only to filter sub_adtype like for rent, investment and sale
        if ($this->ad_subtype != '') {

            $column = match ((int)$this->ad_subtype) {
                1 => 'for_sale',
                0 => 'for_invest',
                2 => 'for_rent',
            };

            $query->andFilterWhere([
                "building.{$column}" => 1
            ]);
        }

        $query->andFilterWhere(['like', 'instrument_number', $this->instrument_number])
            ->andFilterWhere(['like', 'building_name', $this->building_name])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'building_status', $this->building_status])
            ->andFilterWhere(['like', 'user.name', $this->owner_name])
            ->andFilterWhere(['like', 'building.description', $this->description]);

        return $dataProvider;
    }
}
