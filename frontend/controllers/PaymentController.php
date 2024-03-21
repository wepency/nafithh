<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\Plan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\httpclient\Client;
use Yii;
use yii\web\NotFoundHttpException;

class PaymentController extends Controller
{
    public function actionOverview()
    {
        $planId = Yii::$app->session->get('paymentPlan') ?? Yii::$app->session->get('paymentFinal');

        if (Yii::$app->session->has('paymentPlan')) {
            Yii::$app->session->set('paymentFinal', $planId);
            Yii::$app->session->remove('paymentPlan');
        }

        $model = Plan::find()->where(['id' => $planId])->one();

        return $this->render('overview', [
            'model' => $model
        ]);
    }

    public function actionDoPay()
    {
        $planId = Yii::$app->request->get('paramName');

        return $this->AddOrder($planId);
        return $this->payment();
    }

    protected function payment()
    {

        $idorder = 111000;

        $terminalId = 'nafithh';
        $password = 'nafithh@1122';
        $merchant_key = '80d187ca94aea3f8dc38e91ebda1ae05d60f66de644c90db2296d90b894154aa';


        $currencycode = 'SAR';

        $amount = 99;

        $ipp = '197.59.109.30'; // You may use your function to get server IP if required

        $txn_details = "$idorder|$terminalId|$password|$merchant_key|$amount|$currencycode";
        $hash = hash('sha256', $txn_details);

        $fields = [
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => 'customer@email.com',
            'action' => "1",
            'merchantIp' => $ipp,
            'password' => $password,
            'currency' => $currencycode,
            'country' => "SA",
            'amount' => $amount,
            "udf1" => "Test1",
            "udf2" => 'http://google.com',
            "udf3" => "",
            "udf4" => "",
            "udf5" => "Test5",
            'requestHash' => $hash
        ];

        $data = json_encode($fields);

        $httpClient = new Client(['baseUrl' => 'https://payments-dev.urway-tech.com']);
        $response = $httpClient->createRequest()
            ->setMethod('post')
            ->setUrl('/URWAYPGService/transaction/jsonProcess/JSONrequest')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data)
            ])
            ->setContent($data)
            ->send();

        if ($response->isOk) {
            $result = $response->getData();
            if (!empty($result['payid']) && !empty($result['targetUrl'])) {
                $url = $result['targetUrl'] . '?paymentid=' . $result['payid'];
                return Yii::$app->getResponse()->redirect($url);
            } else {
                // Handle error condition
                Yii::error($result, 'Payment error');
                // Debugging information
                var_dump($result);
                die();
            }
        } else {
            // Handle HTTP request error
            Yii::error($response->getContent(), 'HTTP request error');
            // Debugging information
            var_dump($response->getContent());
            die();
        }
    }

    private function AddOrder($planId)
    {
        $plan = $this::findModel($planId);
        $model = new Order();
        $model->plan_id = $plan->id;
        $request = Yii::$app->request;

        return $model->save();
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
        if (($model = Plan::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}