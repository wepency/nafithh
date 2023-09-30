<?php

namespace backend\controllers;

use common\models\StatementReceiptCatch;
use common\models\StatementReceiptCatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii;

/**
 * StatementReceiptCatchController implements the CRUD actions for StatementReceiptCatch model.
 */
class StatementReceiptCatchController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view','update'],
                'rules' => [
                    [
                        'actions' => ['view','update'],
                        'allow' => true,
                        'roles' => ['owner','estate_officer','estate_officer_user','admin','admin_user','owner_estate_officer'],
                        'roleParams' => function ($rule) {
                                return ['statement-receipt-catch' => $this->findModel(yii::$app->request->get('id'))];
                        },
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StatementReceiptCatch models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StatementReceiptCatchSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatementReceiptCatch model.
     * @param int $id الرقم
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StatementReceiptCatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new StatementReceiptCatch();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing StatementReceiptCatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id الرقم
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing StatementReceiptCatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id الرقم
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the StatementReceiptCatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id الرقم
     * @return StatementReceiptCatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatementReceiptCatch::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
