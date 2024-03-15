<?php

namespace backend\controllers;

use common\components\GeneralHelpers;
use common\models\Gallery;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * BalanceContractController implements the CRUD actions for BalanceContract model.
 */
class TakamolatController extends Controller
{
    public array $takamolatKeyTranslator = [
        'obligationsOnTheProperty' => 'obligations',
        'guaranteesAndTheirDuration' => 'guarantees',
        'theBordersAndLengthsOfTheProperty' => 'borders',
        'complianceWithTheSaudiBuildingCode' => 'compliance'
    ];

    public const LOCATION_PARAMS = [
        "buildingNumber",
        "city",
        "district",
        "region"
    ];

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'delete' => ['POST'],
//                    'post-request' => ['POST'],
//                    'toggle-status' => ['POST'],
//                ],
//            ],
//        ];
//    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
//                'only' => ['view', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'post-request', 'step', 'toggle-status', 'delete'],
                        'allow' => true,
                        'roles' => ['estate_officer', 'owner_estate_officer'],
//                        'roles' => function ($user) {
//                            // Use userType column as roles
////                            return [$user->identity->userType];
//                            return true;
//                        },
//                        'roleParams' => function ($rule) {
//                            return ['takamolat' => $this->findModel(Yii::$app->request->get('id'))];
//                        },
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'post-request' => ['POST'],
                    'toggle-status' => ['POST'],
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

//        return $this->render('index');

//        $json = file_get_contents(Yii::getAlias('@common') . '/takamolat.json');
//
//        $json = json_decode($json);
//
////        return dd($json->Body);
///
///
        $userId = Yii::$app->user->id;
        $searchModel = Gallery::find();

        if (in_array(yii::$app->user->identity->user_type, ['estate_officer', 'owner_estate_officer'])) {
            $searchModel = $searchModel->where(['user_id' => $userId]);
        }

        $dataProvider = (new Gallery())->search(Yii::$app->request->queryParams, $searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel->all(),
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $postRequest = Yii::$app->request->post();

        $model = new Gallery;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            return $this->updateOrCreateGallery($postRequest, $model);

        }

        return $this->render('create', [
            'model' => $model,
            'images' => []
        ]);
    }

    public function actionUpdate(int $id)
    {
        $postRequest = Yii::$app->request->post();

        $model = new Gallery;
        $userId = Yii::$app->user->id;
        $model = $model::find()->where(['id' => $id, 'user_id' => $userId])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            return $this->updateOrCreateGallery($postRequest, $model);
        }else {
            $arrImages2 = GeneralHelpers::updateImages($model);
        }

        return $this->render('create', [
            'model' => $model,
            'images' => $arrImages2
        ]);
    }

    private function checkArray($array, $key)
    {
        return array_key_exists($key, $array) ? $array[$key] : null;
    }

    private function updateOrCreateGallery($postRequest, $model)
    {
        $takamolat = $this->getTakamolatCorrrectValue($postRequest['Gallery']['adLicenseNumber'], $postRequest['Gallery']['adLicenseId']);

        if ($takamolat) {
            $takamolat = json_decode(json_encode($takamolat));

            $takamolatResult = $takamolat->Body->result;
            $takamolatAdvertisement = $takamolatResult->advertisement;
            $takamolatLocation = $takamolatAdvertisement->location;

            $modelProperties = array_keys($model->getAttributes());

            $model->creationDate = $this->updateDateFormat($takamolatAdvertisement->creationDate);
            $model->endDate = $this->updateDateFormat($takamolatAdvertisement->endDate);

            foreach ($takamolatAdvertisement as $key => $item) {
                if ($key == 'propertyPrice') {
                    continue;
                }

                if (array_key_exists($key, $this->takamolatKeyTranslator)) {
                    $keyNameInDB = $this->takamolatKeyTranslator[$key];
                    $model->{$keyNameInDB} = $item;
                }

                if (in_array($key, ['propertyUsages', 'propertyUtilities'])) {
                    $item = serialize($item);
                }

                if (in_array($key, $modelProperties)) {
                    $model->{$key} = $item;
                }
            }

            foreach ($takamolatLocation as $key => $item) {
                if (in_array($key, self::LOCATION_PARAMS)) {
                    $model->{$key} = $item;
                }
            }

            $model->load($postRequest);

            $model->user_id = Yii::$app->user->id;
            $model->description = HtmlPurifier::process($postRequest['Gallery']['description'] ?? '');;

            // Ad Status & Options
//                $model->propertyPrice = $post['Gallery']['propertyPrice'] ?? null;
            $model->elevator = $this->checkArray($postRequest, 'elevator') == 'on';
            $model->furniture = $this->checkArray($postRequest, 'furniture') == 'on';
            $model->ac = $this->checkArray($postRequest, 'ac') == 'on';
            $model->status = $this->checkArray($postRequest, 'status') == 'on';

            $model->created_at = Date('Y-m-d H:i:s');

            if ($model->save()) {
                GeneralHelpers::setImages($model);
                // Model saved successfully, redirect or do further actions
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function actionPostRequest()
    {
        // Return the view content as JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        $adLicenseNumber = $_POST['adLicenseNumber'];
        $advertiserId = $_POST['adLicenseId'];

        // Check if the takamolat already exists but not while update
        $isUpdate = $_POST['isUpdate'] ?? false;

        if($this->checkIfExists($adLicenseNumber) && !$isUpdate)
            return ['success' => false, 'error' => Yii::t('app', 'takamolat Already exists')];

        $takamolat = $this->getTakamolatCorrrectValue($adLicenseNumber, $advertiserId);

        if ($takamolat) {
            $takamolat = json_decode(json_encode($takamolat));
            $takamolat = $takamolat->Body;
        } else {
            return ['success' => false, 'error' => Yii::t('app', 'takamolat data bad')];
        }

        $viewContent = $this->renderPartial('_takamolat_data', [
            'takamolat' => $takamolat, // Pass any data needed for the view
        ]);

        return ['success' => true, 'viewContent' => $viewContent];
    }

    private function checkIfExists($adLicenseNumber)
    {
        return Gallery::find()->where(['adLicenseNumber' => $adLicenseNumber])->exists();
    }

    private function getTakamolatCorrrectValue($adLicenseNumber, $advertiserId)
    {
        $takamolat = $this->getTakamolat($adLicenseNumber, $advertiserId);

        if (!$takamolat) {
            $takamolat = $this->getTakamolat($adLicenseNumber, $advertiserId, 2);
        }

        if (YII_ENV == 'dev') {
            $json = file_get_contents(Yii::getAlias('@common') . '/takamolat.json');
            $takamolat = json_decode($json);
        }

        return $takamolat;
    }

    public function getTakamolat($adLicenseNumber, $advertiserId, $idType = 1)
    {
        // Set headers
        $headers = [
            'X-IBM-Client-Id' => '784587cfd52fec53cad8a5c2c875cf61',
            'X-IBM-Client-Secret' => '0bfc97b8de1d7a22be964844b4995251',
            'Content-Type' => 'application/json'
        ];

        $url = 'https://integration-gw.nhc.sa/nhc/prod/v1/brokerage/';
        $url .= 'AdvertisementValidator?adLicenseNumber=' . $adLicenseNumber . '&advertiserId=' . $advertiserId . '&idType=' . $idType;;
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

    public function actionToggleStatus()
    {
        $id = $_POST['id'];
        $model = Gallery::find()->where(['id' => $id])->one();
        $model->status = !$model->status;

        if ($model->validate()) {

            if ($model->save()) {
                return $this->asJson(['success' => true, 'forceClose' => true]);
            }

        } else {
            // Handle validation errors
            return $this->asJson(['success' => false, 'errors' => $model->errors]);
        }
    }

    /**
     *
     */

    public function actionStep($step)
    {
        $model = new Gallery();

        switch ($step) {
            case 2:
                Yii::$app->assetManager->bundles = [
                    'yii\bootstrap\BootstrapAsset' => false,
                ];
                return $this->renderAjax('@backend/views/takamolat/_step2.php');
        }

        return true;
    }

    private function updateDateFormat($dateString)
    {
        $dateTime = \DateTime::createFromFormat('d/m/Y', $dateString);

        // Check if the parsing was successful
        if ($dateTime !== false) {
            // Change the date format
            return $dateTime->format('Y-m-d');
        }

        return $dateTime;
    }

    /**
     * Displays a single BalanceContract model.
     * @return mixed
     */
    public function actionView(int $id)
    {
//        $adLicenseNumber = '7100041957';
//        $advertiserId = '1011260294';

//        dd($this->getTakamolat($adLicenseNumber, $advertiserId,1));

        $model = Gallery::find()->where(['id' => $id])->one();

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete(int $id)
    {
        if (Gallery::deleteAll(['id' => $id])) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Deletes are done successfully.'));
            return $this->redirect(['index']);
        }
    }
}