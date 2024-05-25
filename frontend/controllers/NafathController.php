<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\NafathForm;
use GuzzleHttp\Exception\GuzzleException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use GuzzleHttp\Client;

/**
 * NafathController implements the CRUD actions for City model.
 */
class NafathController extends Controller
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
                    'callback' => ['GET', 'POST'],
                    'create' => ['GET', 'POST'],
                    'send' => ['GET', 'POST'],
                    'check' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new NafathForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $nationalId = Html::encode($model->nationalId);
            return $this->redirect(['nafath/send?n_id='.$nationalId]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionSend()
    {
        $nationalId = $_GET['n_id'];
        $userId = \Yii::$app->user->identity->id;

        $client = new Client();

        if (is_null($_GET['n_id']))
            $this->render('error');


        // URL on which we have to post data
        $url = "https://nafath.api.elm.sa/api/v1/mfa/request?local=ar&requestId=4d736d59-fe13-4105-9406-b79f8b5eb854";

        // Define the headers as an associative array
        $headers = [
            "Content-Type" => "application/json",
            "APP-ID" => "e548e90f",
            "APP-KEY" => "a9181aaae39d6faf85bb8044ffdb280d"
        ];

        // Define the request body as a JSON string (you can use any format you need)
        $requestBody = json_encode([
            "service" => "RecipientApprovalWithoutBio",
            "nationalId" => $nationalId
        ]);

        try {
            // Send a GET request
            $response = $client->post($url, [
                'headers' => $headers,
                'body' => $requestBody
            ]);

            // Check the response status code
            if ($response->getStatusCode() === 201) {
                // Successful response
                $responseData = json_decode($response->getBody(), true);

                $userId = \Yii::$app->user->identity->id;
                $model = User::findOne($userId);

                $model->identity_id = $nationalId;
                $model->transId = $responseData['transId'];

                $model->save(false);

                // Return the JSON data
                return $this->render('modal', ['data' => $responseData]);
            }

        } catch (GuzzleException $e) {
            return $this->render('error');
            return $e->getMessage();
        }
    }

    public function actionCheck()
    {
        $nafathValidated = \Yii::$app->user->identity->nafath_validated;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['token' => (bool)$nafathValidated];
    }
}