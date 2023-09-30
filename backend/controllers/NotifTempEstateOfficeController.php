<?php

namespace backend\controllers;

use Yii;
use common\models\NotifTemp;
use common\models\NotifTempEstateOffice;
use common\models\NotifTempEstateOfficeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotifTempEstateOfficeController implements the CRUD actions for NotifTempEstateOffice model.
 */
class NotifTempEstateOfficeController extends Controller
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
     * Lists all NotifTempEstateOffice models.
     * @return mixed
     */
    public function actionIndex()
    {
        // print_r(NotifTempEstateOffice::NOTIF_AVALIBAL_FOR_ESTATE_OFFICE); die();
        $adminTemps = NotifTemp::find()->where(['id'=> NotifTempEstateOffice::NOTIF_AVALIBAL_FOR_ESTATE_OFFICE ])->all();
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        foreach ($adminTemps as $adminTemp ) {
            $estateOfficeForm = NotifTempEstateOffice::find()->where(['estate_office_id' => $estate_office_id,'notification_id' => $adminTemp->id])->One();
            if(!$estateOfficeForm){
               $model = new  NotifTempEstateOffice();
               $model->name = $adminTemp->name;
               $model->name_en = $adminTemp->name_en;
               $model->title_email = $adminTemp->title_email;
               $model->title_email_en = $adminTemp->title_email_en;
               $model->body_email = $adminTemp->body_email;
               $model->body_email_en = $adminTemp->body_email_en;
               $model->body_sms = $adminTemp->body_sms;
               $model->body_sms_en = $adminTemp->body_sms_en;
               $model->enable_sms = $adminTemp->enable_sms;
               $model->enable_email = $adminTemp->enable_email;
               $model->estate_office_id = $estate_office_id;
               $model->notification_id = $adminTemp->id;;
               $model->save(false);
            }

        }

        $searchModel = new NotifTempEstateOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NotifTempEstateOffice model.
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
     * Creates a new NotifTempEstateOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new NotifTempEstateOffice();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing NotifTempEstateOffice model.
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
     * Deletes an existing NotifTempEstateOffice model.
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
     * Finds the NotifTempEstateOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotifTempEstateOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        if (isset($estate_office_id)){
            $model = NotifTempEstateOffice::find()->where(['estate_office_id'=>$estate_office_id,'id'=>$id])->one();
        }else{
            $model = NotifTempEstateOffice::findOne($id);
        }
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
