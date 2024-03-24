<?php

namespace backend\controllers;

use common\models\Coupon;
use common\models\Gallery;
use common\models\OrderSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CouponsController implements the CRUD actions for Coupon model.
 */
class CouponsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'post-request', 'step', 'toggle-status', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
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
     * Lists all Coupon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Coupon::find();
        $dataProvider = (new Coupon)->search(\Yii::$app->request->queryParams, $searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Coupon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $coupon = $this->findModel($id);

        return $this->render('view', [
            'model' => $coupon,
            'couponUses' => $coupon->couponUses
        ]);
    }

    /**
     * Creates a new Coupon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Coupon;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Coupon added successfully'));
                return $this->redirect('index');
            }

            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error'));
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Coupon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Coupon updated successfully'));
                return $this->redirect('/admin/coupons/index');
            }

            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error'));
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Coupon model.
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
     * Finds the Coupon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coupon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coupon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
