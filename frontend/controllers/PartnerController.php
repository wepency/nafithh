<?php

namespace frontend\controllers;

use Yii;
use common\models\Partner;
use common\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination ;

/**
 * AboutController implements the CRUD actions for About model.
 */
class PartnerController extends Controller
{
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
        $query = Partner::find()->where(['status'=>1])->orderby('id DESC');
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 12]);
		$models = $query->offset($pages->offset)
			->limit($pages->limit)
			->all();
	    $setting = Setting::find()->orderBy('id DESC')->one();
		
        return $this->render('index',[
		'partner'=>$models,
		'pages' => $pages,
		'setting' => $setting,
		]);
    }

    /**
     * Displays a single About model.
     * @param integer $id
     * @return mixed
     */


  
   
}
