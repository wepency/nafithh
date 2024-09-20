<?php

namespace backend\controllers;

use Yii;
use common\models\BalanceSms;
use common\models\BalanceSmsSearch;
use common\components\GeneralHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BalanceSmsController implements the CRUD actions for BalanceSms model.
 */
class BalanceSmsController extends Controller
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
     * Lists all BalanceSms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BalanceSmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BalanceSms model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BalanceSms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BalanceSms();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			
			$model->user_id = \Yii::$app->user->identity->id;
			$model->save();
			
			GeneralHelpers::balanceChange($model,'add');
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BalanceSms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$old_balance = $model->amount;
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$new_balance = $model->amount;
			if ($old_balance>$model->amount){
				$model->amount = $old_balance - $new_balance;
				GeneralHelpers::balanceChange($model,'delete');
			}
			else{
				$model->amount = $new_balance - $old_balance;
				GeneralHelpers::balanceChange($model,'add');
			}
			
			$model->amount = $new_balance;
			$model->save();			
			
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BalanceSms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BalanceSms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BalanceSms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BalanceSms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
