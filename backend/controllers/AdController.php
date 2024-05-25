<?php

namespace backend\controllers;

use common\components\GeneralHelpers;
use common\models\Ad;
use common\models\AdSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller
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
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    // public function actionTest()
    // {
    //     $dd = GeneralHelpers::sendEmail('asdfgh202010@gmail.com','test','test','no-reply@nafithh.sa');
    //     print_r($dd); die();
    // }


    public function actionTest($number)
    {
        $dd = GeneralHelpers::sendSms($number, 'test');
        print_r($dd);
        die();
    }


    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        $json = file_get_contents(Yii::getAlias('@common') . '/takamolat.json');
//
//        $json = json_decode($json);

        $model = $this->findModel($id);

        $adLicenseNumber = $model->adLicenseNumber;
        $advertiserId = $model->adLicenseId;
        $idType = $model->idType;

        $takamolat = $this->getTakamolat($adLicenseNumber, $advertiserId, $idType);

        $takamolat = json_decode(json_encode($takamolat));

        return $this->render('view', [
            'model' => $this->findModel($id),
            'takamolat' => $takamolat->Body
        ]);
    }

    public function getTakamolat($adLicenseNumber, $advertiserId, $idType)
    {
        // Set headers
        $headers = [
            'X-IBM-Client-Id' => '784587cfd52fec53cad8a5c2c875cf61',
            'X-IBM-Client-Secret' => '0bfc97b8de1d7a22be964844b4995251',
            'Content-Type' => 'application/json'
        ];

//        $adLicenseNumber = '710004195';
//        $advertiserId = '1010000001';
//        $idType = '1';

        $url = 'https://integration-gw.nhc.sa/nhc/prod/v1/brokerage/';
        $url .= 'AdvertisementValidator?adLicenseNumber=' . $adLicenseNumber . '&advertiserId=' . $advertiserId . '&idType=' . $idType;
        // $url .= '&clientIP='.urlencode($clientIP).'&protocol='.urlencode($protocol);

        $httpClient = new \yii\httpclient\Client();

        // Make the API request
        $response = $httpClient
            ->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setHeaders($headers)
            ->setFormat(Client::FORMAT_JSON)
            ->send();

        // Validate the response
        if ($response->isOk) {
            return $response->data; // Parsed JSON response
        } else {
            $errorMessage = $response->statusCode . ' ' . $response;
            return false;
//            return $this->asJson(['success' => false, 'error' => $errorMessage]);
        }
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ad();

        if ($model->load(Yii::$app->request->post())) {

            if (!$this->getTakamolat($model->adLicenseNumber, $model->adLicenseId, $model->idType)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'بيانات الإعلان غير صحيحة.'));
                return $this->redirect(['create', [
                    'model' => $model,
                ]]);
            }

            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteFile($id, $attribute = "image")
    {
        return GeneralHelpers::deleteImages(Ad::class, $id, $attribute);
    }

    /**
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
