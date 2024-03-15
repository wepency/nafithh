<?php

namespace backend\controllers;

use Yii;
use common\models\BalanceContract;
use common\models\BalanceContractSearch;
use common\components\GeneralHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BalanceContractController implements the CRUD actions for BalanceContract model.
 */
class BalanceContractController extends Controller
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
     * Lists all BalanceContract models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BalanceContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BalanceContract model.
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
     * Creates a new BalanceContract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BalanceContract();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			
			$model->user_id = \Yii::$app->user->identity->id;
			$model->save();
			
			GeneralHelpers::balanceChange($model,'add',true);
			
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BalanceContract model.
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
				GeneralHelpers::balanceChange($model,'delete',true);
			}
			else{
				$model->amount = $new_balance - $old_balance;
				GeneralHelpers::balanceChange($model,'add',true);
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
     * Deletes an existing BalanceContract model.
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
     * Finds the BalanceContract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BalanceContract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BalanceContract::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
