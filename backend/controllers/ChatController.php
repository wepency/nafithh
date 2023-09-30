<?php

namespace backend\controllers;

use Yii;
use common\models\Chat;
use common\models\ChatHistory;
use common\models\ChatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller
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
     * Lists all Chat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->CurrentUser();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $modelhistory = new ChatHistory();
        $modelhistory->chat_id = $model->id;

        if ($modelhistory->load(Yii::$app->request->post()) && $modelhistory->save()){
            $modelhistory->trigger(ChatHistory::EVENT_NEW); 
            Yii::$app->session->setFlash('success',Yii::t('app','Updates are done successfully.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $this->setChatRead($id);
        return $this->render('view', [
            'model' => $model,
            'modelhistory' => $modelhistory,
        ]);
    }

    /**
     * Creates a new Chat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chat();
        $modelhistory = new ChatHistory();

        if ($model->load(Yii::$app->request->post()) && $modelhistory->load(Yii::$app->request->post()) &&  $modelhistory->validate() && $model->save()){
            $modelhistory->chat_id = $model->id;

            $modelhistory->save();
            $modelhistory->trigger(ChatHistory::EVENT_NEW); 
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelhistory' => $modelhistory,
        ]);
    }

    /**
     * Updates an existing Chat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chat model.
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
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::find()->CurrentUser()->where(['id'=>$id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    protected static function setChatRead($id)
    {
        $history = \common\models\ChatHistory::find()->where(['chat_id' => $id])->unread()->all();
        foreach ($history as $row) {
        $infoCurrent = Chat::getInfoUser();
        $infoSender = Chat::getInfoUser($row->user->id);
            if ($infoCurrent['userId'] == $infoSender['userId'] && $infoCurrent['userType'] == $infoSender['userType']) {
            }else{
                $row->status_read = 1;
                $row->save(false);
                
            }
        }
    }
}
