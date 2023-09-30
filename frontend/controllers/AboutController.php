<?php

namespace frontend\controllers;

use Yii;
use backend\models\About;
use common\models\Setting;
use backend\models\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AboutController implements the CRUD actions for About model.
 */
class AboutController extends Controller
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
        $setting = Setting::find()->orderBy('id DESC')->one();
		 return $this->render('index', [
		'setting'=>$setting,	
        ]);
    }

    /**
     * Displays a single About model.
     * @param integer $id
     * @return mixed
     */


  
   
}
