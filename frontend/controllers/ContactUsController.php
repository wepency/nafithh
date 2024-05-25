<?php

namespace frontend\controllers;

use Yii;
use common\models\ContactUs;
use yii\web\Controller;
use yii\helpers\Html;

//use common\widgets\Alert;



/**
 * ContactUsController implements the CRUD actions for ContactUs model.
 */
class ContactUsController extends Controller
{


    public function actionIndex()
    {

        $model = New ContactUs();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->name = Html::encode($model->name);
            $model->email = Html::encode($model->email);
            $model->mobile = Html::encode($model->mobile);
            $model->title = Html::encode($model->title);
            $model->msg = Html::encode($model->msg);
            $model->status = 0;

            if($model->save()){
                Yii::$app->session->setFlash('success', yii::t('app','Thank you for contacting us, we will respond to you as soon as possible'));
            }else{
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            if(Yii::$app->request->isAjax){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $model = New ContactUs();
                return $this->renderAjax('/site/_contact', [
                    'model'=>$model,
                ]);
            }else{
                return $this->redirect(['index']);
            }
        }

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('/site/_contact', [
                'model'=>$model,
            ]);
        }else{
            return $this->render('index',['model'=>$model]);
        }
    }
   

}
