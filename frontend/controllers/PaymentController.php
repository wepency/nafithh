<?php

namespace frontend\controllers;

use common\models\BalanceContract;
use common\models\BalanceSms;
use common\models\EstateOffice;
use common\models\Order;
use common\models\Plan;
use common\components\GeneralHelpers;
use common\models\Coupon;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Controller;
use yii\httpclient\Client;
use Yii;
use yii\web\NotFoundHttpException;

class PaymentController extends Controller
{
    // Test Credentials
//    private string $baseUrl = 'https://payments-dev.urway-tech.com';
//    private string $terminalId = 'nafithh';
//    private string $password = 'nafithh@1122';
//    private string $merchantKey = '80d187ca94aea3f8dc38e91ebda1ae05d60f66de644c90db2296d90b894154aa';

    // Live Credentials
    private string $baseUrl = 'https://payments.urway-tech.com';
    private string $terminalId = 'nafithh';
    private string $password = 'na_1212@URWAY';
    private string $merchantKey = '58b0a3ca037429f127657d9925dbfe7fa8e191ebf1a2727f0f00c8aa8984e84d';
    private string $currencyCode = 'SAR';
    private string $country = 'SA';

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

    public function actionOverview()
    {
        $planId = Yii::$app->session->get('paymentPlan') ?? Yii::$app->session->get('paymentFinal');

        $allowedUserTypes = ['estate_officer', 'owner'];

        $userType = Yii::$app->user->identity->user_type;


        $error = '';

        if (!in_array($userType, $allowedUserTypes)) {
            $error = Yii::t('app', 'Sorry, this is only for estate officers and owners');
        }

        if (Yii::$app->session->has('paymentPlan')) {
            Yii::$app->session->set('paymentFinal', $planId);
            Yii::$app->session->remove('paymentPlan');
        }

        $model = Plan::find()->where(['id' => $planId])->one();

        return $this->render('overview', [
            'model' => $model,
            'error' => $error
        ]);
    }

    public function actionDoPay()
    {
        $planId = Yii::$app->request->post('planId');
        $couponCode = Yii::$app->request->post('couponCode');

        $order = $this->addOrder($planId, $couponCode);

        return $this->payment($order);
    }


    protected function payment($order)
    {

        $idorder = $order['code'];

        $terminalId = $this->terminalId;
        $password = $this->password;
        $merchantKey = $this->merchantKey;

        $currencyCode = $this->currencyCode;
        $country = $this->country;

        $amount = number_format($order['total'], 2, '.', '');

        $ipp = '197.59.109.30'; // You may use your function to get server IP if required

        $txn_details = "$idorder|$terminalId|$password|$merchantKey|$amount|$currencyCode";
        $hash = hash('sha256', $txn_details);

        $fields = [
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => $order['email'] ?? 'customer@email.com',
            'action' => "1",
            'merchantIp' => $ipp,
            'password' => $password,
            'currency' => $currencyCode,
            'country' => $country,
            'amount' => $amount,
            "udf1" => "Test1",
            "udf2" => Yii::$app->BaseUrl->baseUrl.'/payment/validate',
            "udf3" => "",
            "udf4" => "",
            "udf5" => "Test5",
            'requestHash' => $hash
        ];

        $data = json_encode($fields);

        $httpClient = new Client(['baseUrl' => $this->baseUrl]);
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
                dd($result);
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

    private function addOrder($planId, $coupon)
    {
        $request = Yii::$app->request;

        $plan = $this::findModel($planId);

        $user = Yii::$app->user->identity;

        $planPrice = (float)$plan->price;
        $planPriceTax = (float)GeneralHelpers::taxes($planPrice);

        $discount = 0;

        if (!is_null($coupon)) {
            $coupon = Coupon::find()->where(['coupon' => $coupon])->one();

            if($coupon) {
//                $discount = ($coupon->discount * ($planPrice + $planPriceTax)) / 100;
                $discount = ($coupon->discount * $planPrice ) / 100;
            }
        }

        $model = new Order();

        $model->plan_id = $plan->id;

        $model->company_type = 1;

        $model->name = $user->name;
        $model->admin_id = $user->id;
        $model->email = $user->email;
        $model->mobile = $user->mobile;

        $model->code = $this->generateOrderCode();

        $model->subtotal = $planPrice;

        $model->taxes = ($planPrice - $discount) * .15;

        $model->total = $planPrice - $discount + $model->taxes;

        $model->discount = $discount + ($planPriceTax - $model->taxes) ?? null;
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

            $discount = ($coupon->discount * $planPrice ) / 100;
            $finalPrice = $planPrice + $planPriceTax - $discount;

            $message = "مبروك لقد حصلت للتو على كود خصم بقيمة: " . GeneralHelpers::currency($discount);

            return ['success' => true, 'message' => $message, 'finalPrice' => GeneralHelpers::currency($finalPrice), 'discount' => GeneralHelpers::currency($discount)];
        }

        return ['success' => false, 'finalPrice' => GeneralHelpers::currency($finalPrice + $planPriceTax), 'message' => 'كود الخصم غير صحيح.'];
    }

    public function actionValidate() {
        $trackId = Yii::$app->request->get('TrackId');
        $order = Order::find()->where(['code' => $trackId, 'payment_status' => 0])->one();
        $request = Yii::$app->request;

        if ($order) {
            if ($this->checkStatusOfPayment($request)) {

                $order->payment_status = 1;
                $order->save();

                $transaction = Yii::$app->db->beginTransaction();

                try{

                    $adminId = $order->admin_id;

                    $estateOffice = EstateOffice::findOne(['admin_id' => $order->admin_id]);

                    // Add SMS Balance
                    $balanceSMS = new BalanceSms();

                    $balanceSMS->estate_office_id = $estateOffice->id;
                    $balanceSMS->user_id = $adminId;
                    $balanceSMS->amount = $order->plan->sms;
                    $balanceSMS->price = $order->total;
                    $balanceSMS->expire_date = date('Y-m-d H:i:s', strtotime('+1 year'));

                    $balanceSMS->save();

                    GeneralHelpers::balanceChange($balanceSMS,'add', true);

                    // Add Contracts Balance
                    $balanceContract = new BalanceContract();

                    $balanceContract->estate_office_id = $estateOffice->id;
                    $balanceContract->user_id = $adminId;
                    $balanceContract->amount = $order->plan->contracts;
                    $balanceContract->price = $order->total;
                    $balanceContract->expire_date = date('Y-m-d H:i:s', strtotime('+1 year'));

                    $balanceContract->save();

                    GeneralHelpers::balanceChange($balanceContract,'add', true);

                    $transaction->commit();

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error("Failed to process payment for order {$order->id}: " . $e->getMessage(), __METHOD__);
                }
            }
        }

        return $this->render('validate', ['order' => $order]);
    }

    private function checkStatusOfPayment($request) {
        // Credentials
        $terminalId = $this->terminalId;
        $password = $this->password;
        $merchantKey = $this->merchantKey;

        // Build request hash
        $requestHash = implode('|', [
            $request->get('TranId'),
            $merchantKey,
            $request->get('ResponseCode'),
            $request->get('amount')
        ]);

        $hash = hash('sha256', $requestHash);

        // Validate hash
        if ($hash !== $_GET['responseHash']) {
            return false;
        }

        // Build transaction details
        $txn_details = implode('|', [
            $request->get('TrackId'),
            $terminalId,
            $password,
            $merchantKey,
            $request->get('amount'),
            $this->currencyCode
        ]);
        $requestHash1 = hash('sha256', $txn_details);

        // Prepare API fields
        $apifields = [
            'trackid' => $request->get('TrackId'),
            'terminalId' => $terminalId,
            'action' => '10',
            'merchantIp' => '',
            'password' => $password,
            'currency' => 'SAR',
            'transid' => $request->get('TranId'),
            'amount' => $request->get('amount'),
            'udf5' => '',
            'udf3' => '',
            'udf4' => '',
            'udf1' => '',
            'udf2' => '',
            'requestHash' => $requestHash1
        ];
        $apifields_string = json_encode($apifields);

        // Send API request
        $url = "{$this->baseUrl}/URWAYPGService/transaction/jsonProcess/JSONrequest";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $apifields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($apifields_string)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        // Execute API request
        $apiresult = curl_exec($ch);
        curl_close($ch);

        // Parse API response
        $urldecodeapi = json_decode($apiresult, true);
        $inquiryResponsecode = $urldecodeapi['responseCode'];
        $inquirystatus = $urldecodeapi['result'];

        // Check payment status
        if ($_GET['Result'] === 'Successful' && $_GET['ResponseCode'] === '000' &&
            ($inquirystatus === 'Successful' || $inquiryResponsecode === '000')) {
            // Update contract status or perform other actions
            // Contract::where('code', $request->get('TrackId'))->update(['status' => 1]);
            return true;
        }

        return false;
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