<?php

namespace frontend\controllers;

use backend\models\Request;
use backend\models\Setting;
use common\models\Building;
use common\models\BuildingHousingUnit;
use common\models\City;
use common\models\District;
use common\models\EstateOffice;
use common\models\Gallery;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GalleryController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * Lists all About models.
     * @return mixed
     */
    public function actionIndex()
    {

//		$where =  [];
//		$andWhere =  [0=>'AND'];
//		$orWhere = [];
//        $currentDate =   date("Y-m-d" );
//		$andWhere[] = new  \yii\db\Expression("`ad_expire_date` >= '$currentDate' AND `ad_publish_date` <= '$currentDate' ");
//		$where['ad_status']  = 1;
//		$ad_subtype = Yii::$app->request->get('ad_subtype',1); // default 1 for sale
//
//		// $office_id = Yii::$app->request->post('office_id',false);
//
        $data = Yii::$app->request->get();
//
//		if($ad_subtype == 0)
//			$where['for_invest'] = 1;
//		elseif ($ad_subtype == 2)
//			$where['for_rent'] = 1;
//		else
//			$where['for_sale'] = 1;
//
//		if (!empty($data['ad_type']))
//		{
//			$where['ad_type'] = $data['ad_type'];
//		}
//
//		if (isset($data['building_type_id']) && $data['building_type_id'] !== '' )
//		{
//			$where['building_type_id'] = $data['building_type_id'];
//		}
//
//        if (!empty($data['min_price']))
//		{
//			if($ad_subtype == 0)
//				$andWhere[] = ['>=','invest_price',$data['min_price']];
//			elseif ($ad_subtype == 2)
//				$andWhere[] = ['>=','rent_price',$data['min_price']];
//			else
//				$andWhere[] = ['>=','sale_price',$data['min_price']];
//		}
//
//		if (!empty($data['ad_description']))
//		{
//			$andWhere[] = ['like','ad_description',$data['ad_description']];
//		}
//
//		if (!empty($data['max_price']))
//		{
//			if($ad_subtype == 0)
//				$andWhere[] = ['<=','invest_price',$data['max_price']];
//			elseif ($ad_subtype == 2)
//				$andWhere[] = ['<=','rent_price',$data['max_price']];
//			else
//				$andWhere[] = ['<=','sale_price',$data['max_price']];
//		}
//
//		if (!empty($data['min_space']))
//		{
//			$andWhere[] = ['>=','CONVERT(space , UNSIGNED)',$data['min_space']];
//		}
//
//		if (!empty($data['max_space']))
//		{
//			$andWhere[] = ['<=','CONVERT(space , UNSIGNED)',$data['max_space']];
//		}
//
//		$buildingIds = ArrayHelper::map(
//						Building::find()->select(['building.id'])
//						->andfilterWhere(['building.city_id'=>$data['city_id']?? null])
//						->andfilterWhere(['building.district_id'=>$data['district_id']?? null])
//					    ->andfilterWhere(['estate_office.status_account'=>User::STATUS_ACTIVE])
//
//						// ->andfilterWhere(['like','estate_office.name',$data['estate_name']?? null])
//						->andfilterWhere(['estate_office.id'=>$data['office_id']?? null])
//						->joinWith(['estateContract.estateOffice'])
//						->asArray()->all(),'id','id');
//
//		$housing = BuildingHousingUnit::find()->select($this->selectHousing)
//		->where($where)
//		->andWhere($andWhere)
//		->andWhere(['building_id'=>$buildingIds]);
//
//		// ->joinWith(['building.city'],false)
//		// ->andfilterWhere(['like','housing_unit_name',$data['name']?? null]);
//
//		$query = Building::find()->select($this->selectBuilding)->where($where)
//		->andWhere($andWhere)
//		->andWhere(['id'=>$buildingIds])
//		// ->andfilterWhere(['like','building_name',$data['name']?? null])
//		// ->andfilterWhere(['building_type_id'=>$data['building_type']?? null])
//		->union($housing)
//		->orderby('id DESC');
//
//		$countQuery = clone $query;
//
//		$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 6]);
//		$query = (new ActiveQuery(Building::class))->from(['u' => $query]);
//		$models = $query->offset($pages->offset)
//			->limit($pages->limit)
//			// ->asArray()
//			->all()
//			;
//		// 	echo "<pre>";
//		// print_r($models); die();
//		// print_r($countQuery->count()); die();
//		// print_r($query->createCommand()->params); die();

        // office_id
        //
        // building_type_id

        $buildingTypes = require(Yii::getAlias('@common/config/building-types.php'));

        $models = Gallery::find()->where(['status' => 1]);

        // Ad Subtype
        if (isset($data['ad_subtype']) && $data['ad_subtype'] != '') {
            $models->andFilterWhere(['like', 'advertisementType', $data['ad_subtype']]);
        }

        // Ad description
        if (isset($data['ad_description']) && $data['ad_description'] != '') {
            $models->andFilterWhere(['like', 'description', $data['ad_description']]);
        }

        // Min price
        if (isset($data['min_price']) && $data['min_price'] != '') {
            $models->andWhere(['>=', 'propertyPrice', $data['min_price']]);
        }

        // Max price
        if (isset($data['max_price']) && $data['max_price'] != '') {
            $models->andWhere(['<=', 'propertyPrice', $data['max_price']]);
        }

        // Min space
        if (isset($data['min_space']) && $data['min_space'] != '') {
            $models->andWhere(['>=', 'propertyArea', $data['min_space']]);
        }

        // Max space
        if (isset($data['max_space']) && $data['max_space'] != '') {
            $models->andWhere(['<=', 'propertyArea', $data['max_space']]);
        }

        // Office ID
        if (isset($data['estate_office_id']) && $data['estate_office_id'] != '') {
            $models->andWhere(['user_id' =>  $data['estate_office_id']]);
        }

        //estate_office_id
        if (isset($data['office_id']) && $data['office_id'] != '') {
            $office = EstateOffice::find()->where(['id' => $data['office_id']])->one();
            $models->andWhere(['user_id' =>  $office?->admin_id]);
        }

        // City ID
        if (isset($data['city_id']) && $data['city_id'] != '') {
            $city = City::find()->where(['id' => $data['city_id']])->one();
            $models->andFilterWhere(['like', 'city', $city?->name]);
        }

        // District ID
        if (isset($data['district_id']) && $data['district_id'] != '') {
            $district = District::find()->where(['id' => $data['district_id']])->one();
            $models->andFilterWhere(['like', 'district', $district?->name]);
        }

        // Building Type ID
        if (isset($data['building_type_id']) && $data['building_type_id'] != '') {
            $models->andFilterWhere(['like', 'propertyType', $data['building_type_id']]);
        }

        $ads = $models->all();

        $pages = new Pagination(['totalCount' => $models->count(), 'pageSize' => 12]);

        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('_list', [
                'gallery' => $ads,
                'pages' => $pages
            ]);

        }

        return $this->render('index', [
            'pages' => $pages,
            'ads' => $ads,
            'buildingTypes' => $buildingTypes
        ]);

//		}
    }


    public function actionView($id)
    {
        $model = Gallery::find()->where(['id' => $id])->one();

        $estateOfficer = EstateOffice::find()->where(['admin_id' => $model->user_id])->one();

        return $this->render('view', [
            'model' => $model,
            'estateOfficer' => $estateOfficer
        ]);
    }

    public function actionHousing($id, $type)
    {
        $where = [];
        $currentDate = date("Y-m-d");
        $andWhere = new  \yii\db\Expression("`ad_expire_date` >= '$currentDate' AND `ad_publish_date` <= '$currentDate' ");

        $model = BuildingHousingUnit::find();

        $searchType = Yii::$app->request->get('type', '');
        if ($searchType == 1)
            $where['for_sale'] = 1;
        elseif ($searchType == 2)
            $where['for_rent'] = 1;
        elseif ($searchType == 0)
            $where['for_invest'] = 1;
        else
            throw new NotFoundHttpException('The requested page does not exist.');

        $model->andWhere(['id' => $id, 'ad_status' => 1]);
        $model->andWhere($andWhere);
        $model->andWhere($where);
        $model = $model->one();
        if ($model !== null) {
            return $this->render('housing_view', [
                'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }


    }


    public function getSelectHousing()
    {

        return [
            'id',
            'ad_description',
            'invest_price',
            'rent_price',
            'sale_price',
            'ad_subtype',
            'ad_description',
            'space',
            'rooms', // as number_of_rooms
            new  \yii\db\Expression("NULL `building_age` "),
            new  \yii\db\Expression("NULL `city_id` "),
            new  \yii\db\Expression("NULL `district_id` "),
            new  \yii\db\Expression("'housing' as 'type' "),
            'ad_publish_date', // as number_of_rooms
        ];
    }


    public function getSelectBuilding()
    {

        return [
            'id',
            'ad_description',
            'invest_price',
            'rent_price',
            'sale_price',
            'ad_subtype',
            'ad_description',
            'space',
            'number_of_rooms',
            'building_age',
            'city_id',
            'district_id',
            new  \yii\db\Expression("'building' as 'type' "),
            'ad_publish_date', // as number_of_rooms


        ];
    }


    protected function findModel($id)
    {

        $where = [];
        $currentDate = date("Y-m-d");
        $andWhere = new  \yii\db\Expression("`ad_expire_date` >= '$currentDate' AND `ad_publish_date` <= '$currentDate' ");

        $model = Building::find();

        $searchType = Yii::$app->request->get('type', '');
        if ($searchType == 1)
            $where['for_sale'] = 1;
        elseif ($searchType == 2)
            $where['for_rent'] = 1;
        elseif ($searchType == 0)
            $where['for_invest'] = 1;
        else
            throw new NotFoundHttpException('The requested page does not exist.');

        $model->andWhere(['id' => $id, 'ad_status' => 1]);
        $model->andWhere($andWhere);
        $model->andWhere($where);
        $model = $model->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
