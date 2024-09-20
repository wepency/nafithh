<?php

namespace frontend\controllers;

use Yii;
use common\models\Building;
use common\models\BuildingHousingUnit;

use backend\models\Requist;
use backend\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\data\Pagination ;

/**
 * AboutController implements the CRUD actions for About model.
 */
class GalleryController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all About models.
     * @return mixed
     */
    public function actionIndex()
    {
		$where = [];
		$orWhere = [];
		$searchforRent = null;
		$ajax_theme = '_galleryAjax';
		
		$office_id = Yii::$app->request->post('office_id',false);
		if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $data = Yii::$app->request->get();
			
			// if (!empty($data['estate_type_id']))
			// {
			// 	if ($data['estate_type_id']==1){
			// 		$where['for_sale'] = 1;
			// 	}
			// 	else{
			// 		$searchforRent = true;
			// 		$where['for_rent'] = 1;
			// 	}
			// }else{
			// 	$orWhere = ['or',
			// 	   ['for_rent'=>1],
			// 	   ['for_sale'=>1]
			//    ];
			// }
			
			if (!empty($data['city_id']))
			{
				$where['city_id'] = $data['city_id'];
			}
          
            if (!empty($data['owner_id']))
			{
				$where['owner_id'] = $data['owner_id'];
			}

			if (!empty($data['building_type_id']))
			{

				if ($data['building_type_id']==1)
					$query = Building::find()->where(['ad_status'=>1])->andWhere($where)->orderby('id DESC');
				else{
					if (!empty($data['city_id'])){
						$buildings = ArrayHelper::map(Building::find()->select(['id'])->where(['ad_status'=>1])->andWhere(['city_id'=>$where['city_id']])->asArray()->all(),'id','id');
						//return $buildings;
						$where['building_id'] = $buildings;
						unset($where['city_id']);
					}
					$query = BuildingHousingUnit::find()->where($where)->orderby('id DESC');
					$ajax_theme = '_housingAjax';
				}
			}else{
				$query = Building::find()->where(['ad_status'=>1])->andWhere($where)->orderby('id DESC');

			}

			if(!empty($orWhere)){
				$query->andWhere($orWhere);
			}
			
		}else{
			$query = Building::find()->where(['ad_status'=>1])->andWhere(['or',
			   // ['for_rent'=>1],
			   // ['for_sale'=>1]
		   ])->orderby('id DESC');
		}
		
		$countQuery = clone $query;
		
		$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 6]);
		$models = $query->offset($pages->offset)
			->limit($pages->limit)
			->all();
		if (Yii::$app->request->isAjax){
			return $this->renderAjax($ajax_theme,[
				'gallery'=>$models,
				'pages' => $pages,
				'searchforRent' => $searchforRent,
			]);
		}else{
			return $this->render('index',[
				'gallery'=>$models,
				'pages' => $pages,
				'searchforRent' => $searchforRent,
			]);
		}
    }

 
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionHousing($id)
    {
		if (($model = BuildingHousingUnit::findOne($id)) !== null) {
            return $this->render('housing_view', [
            'model' => $model,
        ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
		
        
    }
	
	
    protected function findModel($id)
    {
        if (($model = Building::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
