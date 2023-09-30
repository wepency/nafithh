<?php

namespace backend\controllers;

use Yii;
use common\models\Plan;
use common\models\PlanItem;
use common\models\PlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\helpers\ArrayHelper;


/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
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
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plan model.
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

    public function actionCreate()
    {
        $model = new Plan();

        $modelsPlanItem = [new PlanItem];


        if ($model->load(Yii::$app->request->post())) {
            $valid = $model->validate();
            $modelsPlanItem = Model::createMultiple(PlanItem::class);
            Model::loadMultiple($modelsPlanItem, Yii::$app->request->post());
            $valid = Model::validateMultiple($modelsPlanItem) && $valid;
            if ($valid) {
                $model->save();

                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = ($model->id!=NULL) ) {
                            foreach ($modelsPlanItem as $modelPlanItem) 
                            {
                                $modelPlanItem->plan_id = $model->id;
                                if (! ($flag = $modelPlanItem->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                return $this->redirect(['view', 'id' => $model->id]);

            }else{
                return $this->render('create', [
                    'model' => $model,
                    'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem,
        ]);
    }

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelsPlanItem = PlanItem::find()->where(['plan_id'=>$model->id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $valid = $model->validate();

            /**************** PlanItem *********************/
            $oldIDsUpsell = ArrayHelper::map($modelsPlanItem, 'id', 'id');
            $modelsPlanItem = Model::createMultiple(PlanItem::class, $modelsPlanItem);
            Model::loadMultiple($modelsPlanItem, Yii::$app->request->post());
            $deletedIDsUpsell = array_diff($oldIDsUpsell, array_filter(ArrayHelper::map($modelsPlanItem, 'id', 'id')));
            $valid = Model::validateMultiple($modelsPlanItem) && $valid;

            if ($valid) {
                $model->save();

                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = ($model->id!=NULL)) {
                            if (! empty($deletedIDsUpsell)) {
                                PlanItem::deleteAll(['id' => $deletedIDsUpsell]);
                              }
                            foreach ($modelsPlanItem as $modelPlanItem) 
                            {
                                $modelPlanItem->plan_id = $model->id;
                                if (! ($flag = $modelPlanItem->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }

            }else{
                return $this->render('update', [
                    'model' => $model,
                    'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem,
                ]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelsPlanItem' => (empty($modelsPlanItem)) ? [new PlanItem] : $modelsPlanItem,
        ]);
    }


    /**
     * Deletes an existing Plan model.
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


    public function actionDeleteFile($id , $attribute="image")
    {        
        return \common\components\GeneralHelpers::deleteImages(Plan::class,$id ,$attribute);
    }

    /**
     * Finds the Plan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
