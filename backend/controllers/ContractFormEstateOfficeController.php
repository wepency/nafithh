<?php

namespace backend\controllers;

use Yii;
use common\models\ContractForm;
use common\models\ContractFormEstateOffice;
use common\models\ContractFormEstateOfficeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContractFormEstateOfficeController implements the CRUD actions for ContractFormEstateOffice model.
 */
class ContractFormEstateOfficeController extends Controller
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
     * Lists all ContractFormEstateOffice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $adminForms = ContractForm::find()->where(['status' => 1])->all();
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        foreach ($adminForms as $adminForm ) {
            $estateOfficeForm = ContractFormEstateOffice::find()->where(['estate_office_id' => $estate_office_id,'contract_form_id' => $adminForm->id])->One();
            if(!$estateOfficeForm){
               $model = new  ContractFormEstateOffice();
               $model->contract_form_name = $adminForm->name;
               $model->contract_form_name_en = $adminForm->name_en;
               $model->contract_form_text = $adminForm->body;
               $model->contract_form_text_en = $adminForm->body_en;
               $model->contract_form_name_en = $adminForm->name_en;
               $model->estate_office_id = $estate_office_id;
               $model->contract_form_id = $adminForm->id;
               $model->status = 1;
               $model->save();
            }
        }

        $searchModel = new ContractFormEstateOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContractFormEstateOffice model.
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
     * Creates a new ContractFormEstateOffice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ContractFormEstateOffice();
        $model->estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ContractFormEstateOffice model.
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
     * Deletes an existing ContractFormEstateOffice model.
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
     * Finds the ContractFormEstateOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContractFormEstateOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        if (isset($estate_office_id)){
            $model = ContractFormEstateOffice::find()->where(['estate_office_id'=>$estate_office_id,'id'=>$id])->one();
        }else{
            $model = ContractFormEstateOffice::findOne($id);
        }
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

    }
}
