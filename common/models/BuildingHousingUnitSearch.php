<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BuildingHousingUnit;

/**
 * BuildingHousingUnitSearch represents the model behind the search form of `common\models\BuildingHousingUnit`.
 */
class BuildingHousingUnitSearch extends BuildingHousingUnit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'building_id', 'floors_no', 'building_type_id', 'rooms', 'entrances', 'has_parking', 'toilets', 'kitchen', 'conditioner_num', 'pool', 'using_for', 'status','lounge','ad_subtype','for_rent','for_sale','for_invest','ad_status'], 'integer'],
            [['housing_unit_name', 'area', 'furniture', 'detail'], 'safe'],
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
        $query = BuildingHousingUnit::find();

        $user = yii::$app->user->identity;
        $query->orderBy([ 'id' => ['defaultOrder' => SORT_DESC]]);
        $andFilter = [];
        switch ($user->role) {
            case 'renter':
                $query->joinWith('contract');
                $andFilter = [
                    'contract.renter_id' => $user->id
                ];
                break;
            case 'owner':
                $query->joinWith('building');
                $query->where(['building.owner_id' => $user->id]);
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $query->joinWith('building.estateContract');
                $andFilter = [
                    'estate_office_building.estate_office_id' => $estate_office_id,
                    'estate_office_building.is_active' => 1
                ];
                break;
            
            default:
                # code...
                break;
        }
        // print_r($query->all()); die();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);
        $query->andFilterWhere($andFilter);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'building_housing_unit.id' => $this->id,
            'building_housing_unit.building_id' => $this->building_id,
            'floors_no' => $this->floors_no,
            'building_housing_unit.building_type_id' => $this->building_type_id,
            'building_housing_unit.rent_price' => $this->rent_price,
            'rooms' => $this->rooms,
            'entrances' => $this->entrances,
            'has_parking' => $this->has_parking,
            'toilets' => $this->toilets,
            'building_housing_unit.kitchen' => $this->kitchen,
            'conditioner_num' => $this->conditioner_num,
            'pool' => $this->pool,
            'lounge' => $this->lounge,
            'building_housing_unit.ad_status' => $this->ad_status,
            'building_housing_unit.using_for' => $this->using_for,
            'building_housing_unit.status' => $this->status,
//            'building_housing_unit.for_rent' => $this->for_rent,
//            'building_housing_unit.for_invest' => $this->for_invest,
//            'building_housing_unit.for_sale' => $this->for_sale,
            'building_housing_unit.sale_price' => $this->sale_price,
//            'building_housing_unit.ad_subtype' => $this->ad_subtype
        ]);

        // This custom filter only to filter sub_adtype like for rent, investment and sale
        if ($this->ad_subtype != '') {

            $column = match ((int)$this->ad_subtype) {
                1 => 'for_sale',
                0 => 'for_invest',
                2 => 'for_rent',
            };

            $query->andFilterWhere([
                "building_housing_unit.{$column}" => 1
            ]);
        }

        $query->andFilterWhere(['like', 'housing_unit_name', $this->housing_unit_name])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'furniture', $this->furniture])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
