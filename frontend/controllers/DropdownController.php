<?php

namespace frontend\controllers;

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
    // public $enableCsrfValidation = false;

	public function actions()
	{
	    return \yii\helpers\ArrayHelper::merge(parent::actions(), [
	        'district' => [
	            'class' => \kartik\depdrop\DepDropAction::class,
	            'enableCsrfValidation'=>false,
	            'allowEmpty'=>true,
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
	        
	    ]);
	}


}
