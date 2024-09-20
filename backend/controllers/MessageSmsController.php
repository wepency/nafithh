<?php

namespace backend\controllers;

use Yii;
use common\models\MessageSms;
use common\models\MessageSmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * MessageSmsController implements the CRUD actions for MessageSms model.
 */
class MessageSmsController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all MessageSms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MessageSms model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MessageSms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessageSms();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->sendSMS($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MessageSms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->numbers) $model->modelNumber = explode(",",$model->numbers);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $this->sendSMS($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function sendSMS( &$model)
    {
        $success = $errors = 0;
        $numbers = array();

        if($model->groups){
            
            foreach ($model->groups as $key) {
                // if(isset($listGroup[$key])){
                $listGroup = \common\components\GeneralHelpers::listUserAndOfficeByCurrent($key);
                $listNumberGroup =  ArrayHelper::getColumn($listGroup, 'mobile');
                if($listNumberGroup)
                    $numbers = array_merge($listNumberGroup,$numbers);
                // }
            }
             // die();
        }
        if($model->modelNumber){
            $numbers = array_merge($model->modelNumber,$numbers);
            $model->numbers = implode(",",$model->modelNumber);
        }
        $model->save();



        if($numbers && is_array($numbers) ){

            foreach ($numbers as $key) {
                $statusSend = \common\components\GeneralHelpers::sendSms($key,$model->message);

                ($statusSend['status'] == true)? $success++ : $errors++ ;

                $log = new \common\models\LogMessage();
                $log->sender_id = 0;
                $log->sender_type = 'admin';
                $log->notif_temp_id = 0 ;
                $log->receiver_id = 0;
                $log->receiver_type = 0;
                $log->contact_mobile = $key;
                $log->contact_email = '';
                $log->message = $model->message;
                $log->status = $statusSend['message'];
                $log->save(false);

            }
            Yii::$app->session->setFlash('success', Yii::t('app', '{count} Have been sent successfully.',['count'=>$success]));
            Yii::$app->session->setFlash('error', Yii::t('app', '{count} have not been sent.',['count'=>$errors]));
        }else{
            Yii::$app->session->setFlash('error', Yii::t('app', 'Messages have not been sent.'));
        } 
    }

    /**
     * Deletes an existing MessageSms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MessageSms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessageSms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessageSms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
