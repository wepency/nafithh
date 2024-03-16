<?php

namespace frontend\controllers;

use Yii;
use common\models\Plan;
use common\models\Order;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
{
    /**
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {

        $models = Plan::find()->where(['status' => 1])->orderBy('sort_at ASC')->all();

        return $this->render('index', [
            'model' => $models,
        ]);
    }

    /**
     * Displays a single Plan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionOrder($plan_id)
    {
        return $this->payment();

        $plan = $this::findModel($plan_id);
        $model = new Order();
        $model->plan_id = $plan->id;
        $request = Yii::$app->request;
        $model->detail_field = ArrayHelper::merge($model->detail_field, Yii::$app->request->post('DetailPayField', []));

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->name = Html::encode($model->name);
            $model->email = Html::encode($model->email);
            $model->mobile = Html::encode($model->mobile);
            $model->company_name = Html::encode($model->company_name);
            $model->status = 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', yii::t('app', "Your Order has been Sent Successfully,and We Will Contact You Soon"));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            if (Yii::$app->request->isAjax) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // $model = New Order();
                return $this->renderAjax('order', [
                    'model' => $model,
                ]);
            } else {
                return $this->redirect(['order', 'plan_id' => $plan_id]);
            }
        }

        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('order', [
                'model' => $model,
            ]);
        } else {
            return $this->render('order', ['model' => $model]);
        }


        // if($request->isAjax){

        //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //     if($request->isGet){
        //         return [
        //             'content'=>$this->renderFile('@frontend/views/plan/form.php',['model'=>$model]),

        //         ];

        //     }else if($model->load(Yii::$app->request->post()) && $model->save()){
        //        return  [
        //             // 'error'=>true,
        //             // 'forceClose'=>true,
        //         'content'=> '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        //             <h4 class="text-success">'.yii::t('app',"Your Order has been Sent Successfully,and We Will Contact You Soon").'</h4>',
        //         ];         
        //     }else{
        //         return [
        //             'content'=>$this->renderFile('@frontend/views/plan/form.php',['model'=>$model]),
        //         ];         
        //     }
        // }else{
        //     /*
        //     *   Process for non-ajax request
        //     */
        //     return $this->redirect('index');
        // }
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

    protected function payment()
    {

        $idorder = 111000;

        $terminalId = 'nafithh';
        $password = 'nafithh@1122';
        $merchant_key = '80d187ca94aea3f8dc38e91ebda1ae05d60f66de644c90db2296d90b894154aa';

//        $terminalId = 'nafithh';
//        $password = 'nafithh@1122';
//        $merchant_key = '80d187ca94aea3f8dc38e91ebda1ae05d60f66de644c90db2296d90b894154aa';


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
}
