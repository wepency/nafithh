<?php

namespace frontend\controllers;

<<<<<<< HEAD
use common\models\Order;
use common\models\Plan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
=======
use common\components\GeneralHelpers;
use common\models\Coupon;
use common\models\Order;
use common\models\Plan;
use yii\filters\VerbFilter;
use yii\web\Response;
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
use yii\web\Controller;
use yii\httpclient\Client;
use Yii;
use yii\web\NotFoundHttpException;
<<<<<<< HEAD

class PaymentController extends Controller
{
=======
use yii\helpers\Url;

class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'do-pay' => ['post'],
                    'check-coupon' => ['post'],
                ],
            ],
        ];
    }

>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
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
<<<<<<< HEAD
        $planId = Yii::$app->request->get('paramName');

        return $this->AddOrder($planId);
        return $this->payment();
    }

    protected function payment()
    {

        $idorder = 111000;
=======
        $planId = Yii::$app->request->post('planId');
        $couponCode = Yii::$app->request->post('couponCode');

        $order = $this->addOrder($planId, $couponCode);

        return $this->payment($order);
    }

    protected function payment($order)
    {

        $idorder = $order['code'];
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8

        $terminalId = 'nafithh';
        $password = 'nafithh@1122';
        $merchant_key = '80d187ca94aea3f8dc38e91ebda1ae05d60f66de644c90db2296d90b894154aa';


        $currencycode = 'SAR';

<<<<<<< HEAD
        $amount = 99;
=======
        $amount = $order['total'];
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8

        $ipp = '197.59.109.30'; // You may use your function to get server IP if required

        $txn_details = "$idorder|$terminalId|$password|$merchant_key|$amount|$currencycode";
        $hash = hash('sha256', $txn_details);

        $fields = [
            'trackid' => $idorder,
            'terminalId' => $terminalId,
<<<<<<< HEAD
            'customerEmail' => 'customer@email.com',
=======
            'customerEmail' => $order['email'] ?? 'customer@email.com',
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
            'action' => "1",
            'merchantIp' => $ipp,
            'password' => $password,
            'currency' => $currencycode,
            'country' => "SA",
            'amount' => $amount,
            "udf1" => "Test1",
<<<<<<< HEAD
            "udf2" => 'http://google.com',
=======
            "udf2" => Yii::$app->BaseUrl->baseUrl.'/payment/validate',
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
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

<<<<<<< HEAD
    private function AddOrder($planId)
    {
        $plan = $this::findModel($planId);
        $model = new Order();
        $model->plan_id = $plan->id;
        $request = Yii::$app->request;

        return $model->save();
=======
    private function addOrder($planId, $coupon)
    {
        $request = Yii::$app->request;
        $plan = $this::findModel($planId);

        $user = Yii::$app->user->identity;

        $planPrice = (float)$plan->price;
        $planPriceTax = (float)GeneralHelpers::taxes($planPrice);
        $finaPrice = $planPrice+$planPriceTax;
        $discount = 0;

        if (!is_null($coupon)) {
            $coupon = Coupon::find()->where(['coupon' => $coupon])->one();

            if($coupon) {
                $discount = ($coupon->discount * ($planPrice + $planPriceTax)) / 100;
            }
        }

        $model = new Order();

        $model->plan_id = $plan->id;

        $model->company_type = 1;

        $model->name = $user->name;
        $model->email = $user->email;
        $model->mobile = $user->mobile;

        $model->code = $this->generateOrderCode();
//
        $model->subtotal = $finaPrice;
        $model->total = $finaPrice - $discount;
//
        $model->discount = $discount ?? null;
        $model->coupon = $coupon?->coupon ?? null;
        $model->coupon_id = $coupon->id ?? null;

        if ($model->validate()) {
            if($model->save()){
                Yii::info($model->attributes, 'debug');
                return $model->attributes;
            }

        }

        return $model->errors;
    }

    private function generateOrderCode()
    {
        $code = rand(111111111, 999999999);

        if (Order::find()->where(['code' => $code])->count())
            $this->generateOrderCode();

        return $code;
    }

    public function actionCheckCoupon()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $couponCode = Yii::$app->request->post('couponCode');
        $planId = Yii::$app->request->post('planId');

        $coupon = Coupon::find()->where(['coupon' => $couponCode])->one();
        $plan = Plan::find()->where(['id' => $planId])->one();
        $planPrice = $finalPrice = $plan->price;
        $planPriceTax = (float)GeneralHelpers::taxes($planPrice);

        if ($coupon) {

            $discount = ($coupon->discount * ($planPrice + $planPriceTax)) / 100;
            $finalPrice = $planPrice + $planPriceTax - $discount;

            $message = "مبروك لقد حصلت للتو على كود خصم بقيمة: " . GeneralHelpers::currency($discount);

            return ['success' => true, 'message' => $message, 'finalPrice' => GeneralHelpers::currency($finalPrice), 'discount' => GeneralHelpers::currency($discount)];
        }

        return ['success' => false, 'finalPrice' => GeneralHelpers::currency($finalPrice + $planPriceTax), 'message' => 'كود الخصم غير صحيح.'];
    }

    public function actionValidate() {
        $trackId = Yii::$app->request->get('TrackId');
        $order = Order::find()->where(['code' => $trackId])->one();

        return $this->render('validate', ['order' => $order]);
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
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