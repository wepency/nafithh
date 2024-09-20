<?php

namespace backend\controllers;

use Yii;
use common\models\District;
use common\models\User;
use common\models\Chat;
use common\models\Building;
use common\models\EstateOffice;
use common\models\MaintenanceOffice;
use common\models\BuildingHousingUnit;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;


class DropdownController extends \yii\web\Controller
{

	public function actions()
{
    return \yii\helpers\ArrayHelper::merge(parent::actions(), [
        'district' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'outputCallback' => function ($selectedId, $params) {
            	$list = District::ListDistrictByCar($selectedId);
            	$out = [];
				
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
        'housing' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'outputCallback' => function ($selectedId, $params) {
            	$list = BuildingHousingUnit::ListHousingByBuilding($selectedId);
            	$out = [];
				
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
        'housing-unrented' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'outputCallback' => function ($selectedId, $params) {
            	$list = BuildingHousingUnit::ListHousingByBuildingUnrented($selectedId);
            	$out = [];
				
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
        'building' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'outputCallback' => function ($selectedId, $params) {
            	$list = Building::ListBuildingByOwner($selectedId);
            	$out = [];
				
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
        'chatSendTo' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'outputCallback' => function ($selectedId, $params) {
		        $sender_type = Chat::getInfoUser();
		        $droptions = \common\components\GeneralHelpers::listUserAndOfficeByCurrent($selectedId);
            	switch ($selectedId) {
            		case 'admin':
            		case 'owner': // view for :'admin','estate_officer','renter'
            		case 'renter':// view for 'admin','estate_officer','owner'
            		case 'estate_officer': // view for 'admin','renter','owner'
            		case 'maintenance_officer':
				        $list =   \yii\helpers\Arrayhelper::map($droptions, 'id', 'name');
            			break;
            		default:
            			# code...
            			break;
            	}
		        $list =   \yii\helpers\Arrayhelper::map($droptions, 'id', 'name');
            	$out = [];
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
        'maintenance' => [
            'class' => \kartik\depdrop\DepDropAction::class,
            'allowEmpty'=>true,
            'outputCallback' => function ($selectedId, $params) {
            	$query = MaintenanceOffice::find();
            	if(isset($params[0]) &&  $params[0]){
            		$query->andWhere(['city_id'=>$params[0]]);
            	}
            	if(isset($params[1]) &&  $params[1]){
            		$query->andWhere(['district_id'=>$params[1]]);
            	}
            	$list = ArrayHelper::map($query->all(),'id','name');
            	$out = [];
				
	            foreach ($list as $i => $data) {
	                $out[] = [
							'id' => $i,
							'name' => $data
						];
	            }
                return $out;
            }
        ],
    ]);
}

	 /*
    *
    */
	/*
    public function actionCarType() {
    	
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

	    $out = [];
	    if (isset($_POST['depdrop_parents'])) {
	        $parents = $_POST['depdrop_parents'];
	        
	        if ($parents != null) {
	            $brand_id = $parents[0];

	            $list = CarType::getCarTypeList2($brand_id);

	            foreach ($list as $i => $data) {
	                $out[] = ['id' => $data['id'], 'name' => (Yii::$app->language=='ar') ? $data['name'] : $data['name_en']];
	               
	            }

	            $selected = []; 

	            echo Json::encode(['output'=>$out, 'selected'=>'']);
	        }
	    }
	    echo Json::encode(['output'=>$out, 'selected'=>'']);
	} */
	


}
