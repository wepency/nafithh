<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\ContactForm;
use common\models\Subscribe;
use common\models\Setting;

use yii\helpers\ArrayHelper;


/**
 * AboutController implements the CRUD actions for About model.
 */
class SubscribeController extends Controller
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
		$model = new Subscribe();
         if ($model->load(Yii::$app->request->post() ) && $model->validate() ) {
            if (Yii::$app->request->post()) {//print_r('ffffff');die;
			$model->message = strip_tags($model->message);
				$model->save(false);
				  Yii::$app->session->setFlash('success', Yii::t('app','Thank you for subscribe us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','There was an error sending your subscribe.'));
            }
            return $this->refresh();
		
        } else {//print_r($model->getErrors());die();
            return $this->render('index', [
                'model' => $model,
				
				
            ]);
        }
		
	
    }
	
   /* public function actionIndex()
    {
        
		$Setting = Setting::find()->orderBy('id DESC')->one();
		$model = new Contact();
		$contact_us_page_setting = ContactUsPageSettings::findOne(1);
       if ($model->load(Yii::$app->request->post()  ) && $model->validate() ) {
            if (Yii::$app->request->post()) {
			$model->message = strip_tags($model->message);
				$model->save(false);
			    $to  = $Setting->email ;
				$from= $model->name;
				$subject = $model->name;
				$message = "
						  <html>
						  <head>
						  <title>". $subject."</title>
						  </head>
						  <body>
						  <p>". Yii::t('app','Hello')."</p>
						  <p>". $model->message ."</p>
						  <br/>
						  <br/>
						  <p>".Yii::t('app','Thank You') ."</P>
						  
						  </body>
						   <p>". $from."</P>
						   <p>". $model->email."</P>
						  
						  </html>
						  ";

			//print_r($model->country);die();	
			//Contact::sendEmailUser($to,$subject,$message,$from);
		
                Yii::$app->session->setFlash('success', Yii::t('app','Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','There was an error sending your message.'));
            }
            return $this->refresh();
        } else {//print_r($model->getErrors());die();
            return $this->render('index', [
                'model' => $model,
				'Setting' => $Setting,
				'contact_us_page_setting' => $contact_us_page_setting,
				
            ]);
        }
		
	
    }*/
	
	
}
