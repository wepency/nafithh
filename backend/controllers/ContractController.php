<?php

namespace backend\controllers;

use common\components\GeneralHelpers;
use common\models\Contract;
use common\models\ContractFormEstateOffice;
use common\models\ContractSearch;
use common\models\Installment;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BuildingController implements the CRUD actions for Building model.
 */
class ContractController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view', 'update'],
                'rules' => [
                    [
                        'actions' => ['view', 'update'],
                        'allow' => true,
                        'roles' => ['owner', 'estate_officer', 'estate_officer_user', 'renter', 'admin', 'admin_user', 'owner_estate_officer'],
                        'roleParams' => function ($rule) {
                            return ['contract' => $this->findModel(Yii::$app->request->get('id'))];
                        },
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'ending' => ['POST'],
                ],
            ],
        ];
    }

    public function actionStep($step)
    {
        $owner = $this::getOwner();
        $model = new Contract();

        switch ($step) {
            case 1:
                Yii::$app->assetManager->bundles = [
                    'yii\bootstrap\BootstrapAsset' => false,
                ];
                return $this->renderAjax('@backend/views/contract/_check-or-add.php');
                break;
            case 2:
                Yii::$app->assetManager->bundles = [
                    'yii\bootstrap\BootstrapAsset' => false,
                ];
                $estate_office_id = GeneralHelpers::getEstateOfficeId();
                $buildings = (new \yii\db\Query())
                    ->select(['building.building_name', 'building.id'])
                    ->from('estate_office_building')
                    ->where(['estate_office_building.estate_office_id' => $estate_office_id, 'is_active' => 1, 'estate_office_building.owner_id' => $owner->id])
                    ->leftJoin('building', 'building.id = estate_office_building.building_id')
                    ->all();
                $buildings = ArrayHelper::map($buildings, 'id', 'building_name');
                return $this->renderAjax('@backend/views/contract/_select_housing.php', [
                    'model' => $model,
                    'owner' => $owner,
                    'buildings' => $buildings
                ]);
                break;
            case 3:
                Yii::$app->assetManager->bundles = [
                    'yii\bootstrap\BootstrapAsset' => false,
                ];
                return $this->renderAjax('@backend/views/contract/_check-or-add-renter.php', ['owner' => $owner]);
                break;

            case 4:
                $arrImages2 = [];
                $housing = $this::getHousing();
                $model->price = $housing->rent_price;
                Yii::$app->assetManager->bundles = [
                    'yii\bootstrap\BootstrapAsset' => false,
                ];
                $renter = $this::getRenter();
                return $this->renderAjax('@backend/views/contract/_add_contract.php', [
                    'owner' => $owner,
                    'arrImages2' => $arrImages2,
                    'renter' => $renter,
                    'model' => $model
                ]);
                break;
            default:
                return $this->redirect('create');
                break;
        }

    }

    /**
     * Lists all Building models.
     * @return mixed
     */
    public function actionCheckOrAdd($identity_id = '')
    {
        $request = Yii::$app->request;
        $model = new User();
        $owner = User::find()->where(['identity_id' => $identity_id])->AndWhere(['or', ['user_type' => 'owner'], ['owner' => 1]])->One();
        $session = Yii::$app->session;
        if (yii::$app->user->identity->user_type === 'owner_estate_officer') {

            $owner = User::findOne(yii::$app->user->identity->id);
        }
        if ($owner) {
            $session['owner_identity_id'] = $identity_id;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['error' => false];
        } else {
            $session['owner_identity_id'] = null;
        }

        $arrImages2 = [];
        if ($request->isAjax) {

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {

                return [
                    'error' => true,
                    'title' => yii::t('app', "Create Owner"),
                    'content' => $this->renderAjax('/owner/_form', [
                        'model' => $model,
                        'arrImages2' => $arrImages2,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->validate()) {
                GeneralHelpers::setImages($model);

                \backend\models\Signup::signup($model, 'owner');
                $session['owner_identity_id'] = $model->identity_id;
                return ['error' => true, 'forceClose' => true,];

            } else {
                return [
                    'title' => yii::t('app', "Create Owner"),
                    'content' => $this->renderAjax('/owner/_form', [
                        'model' => $model,
                        'arrImages2' => $arrImages2,

                    ]),
                    'footer' => Html::button(yii::t('app', "Close"), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(yii::t('app', "Save"), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect('create');
        }
    }

    public function actionCheckOrAddRenter($identity_id = '')
    {
        $request = Yii::$app->request;
        $model = new User();
        $modelRenter = new \common\models\Renter();

        $renter = User::find()->where(['identity_id' => $identity_id])->AndWhere(['or', ['user_type' => 'renter'], ['renter' => 1]])->One();

        $session = Yii::$app->session;
        if ($renter) {
            $session['renter_identity_id'] = $identity_id;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['error' => false];
        } else {
            $session['renter_identity_id'] = null;
        }
        $arrImages2 = [];

        if ($request->isAjax) {

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {

                return [
                    'error' => true,
                    'title' => yii::t('app', "Create Renter"),
                    'content' => $this->renderAjax('/renter/_form', [
                        'model' => $model,
                        'modelRenter' => $modelRenter,
                        'arrImages2' => $arrImages2,
                    ]),
                    'footer' => Html::button(yii::t('app', "Close"), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(yii::t('app', "Save"), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];

            } else if ($model->load(Yii::$app->request->post()) && $modelRenter->load(Yii::$app->request->post()) && $model->validate() && $modelRenter->validate()) {
                GeneralHelpers::setImages($model);

                $session['renter_identity_id'] = $model->identity_id;
                \backend\models\Signup::signup($model, 'renter');
                return ['error' => true, 'forceClose' => true];
            } else {
                return [
                    'title' => yii::t('app', "Create Renter"),
                    'content' => $this->renderAjax('/renter/_form', [
                        'model' => $model,
                        'modelRenter' => $modelRenter,
                        'arrImages2' => $arrImages2,

                    ]),

                    'footer' => Html::button(yii::t('app', "Close"), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button(yii::t('app', "Save"), ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect('create');
        }
    }

    public function actionAddHousingUnit()
    {
        $request = Yii::$app->request;
        $model = new Contract();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->get()) && $model->housing_unit_id) {
            $session = Yii::$app->session;
            $session['housing_unit'] = $model->housing_unit_id;

            return ['error' => false];
        }
        return [
            'title' => yii::t('app', "Error"),
            'content' => yii::t('app', "Housing Unit") . ' ' . yii::t('app', "cannot be blank"),
            'error' => true,
            'footer' => Html::button(yii::t('app', "Close"), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])

        ];
    }

    public function actionAddContract()
    {

        $request = Yii::$app->request;
        $model = new Contract();
        $owner = $this::getOwner();
        $renter = $this::getRenter();
        $housing = $this::getHousing();
        $arrImages2 = [];

        if ($request->isAjax) {
            if ($model->load($request->post())) {

                $model->estate_office_id = GeneralHelpers::getEstateOfficeId();
                $model->owner_id = $owner->id;
                $model->building_id = $housing->building_id;
                $model->housing_unit_id = $housing->id;
                $model->renter_id = $renter->id;

                $model->user_created_id = Yii::$app->user->identity->id;
                // إذا كان ات الوحدة تجارية يتم احتسا الضريبة من الاعدادات العامة
                if ($housing->using_for == 1) {
                    $added_tax_setting = yii::$app->SiteSetting->info()->added_tax;
                    if ($added_tax_setting > 0 && $model->price > 0)
                        $model->added_tax = round(($added_tax_setting * $model->price) / 100, 2);
                }

                if ($model->include_water == 1 && $model->water_amount > 0) {
                    $model->price = $model->price + $model->water_amount;
                }

                // إذا كانت مسودة

                if ($model->validate()) {
                    if (isset($request->post()['is_draft'])) {
                        $model->is_draft = 1;
                        $model->save();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Contract Saved As Draft.'));

                        return $this->redirect('create');
                    }


                    $model->contract_no = $this::ContractNo();
                    $model->save();


                    GeneralHelpers::setImages($model);

                    $housing->status = 1;
                    $housing->save(false);
                    // الخصم من رصيد العقود من المكتب
                    $estatOffice = \common\models\EstateOffice::findOne($model->estate_office_id);
                    $estatOffice->contract_balance -= 1;
                    $estatOffice->save(false);

                    $model->trigger(Contract::EVENT_NEW);

                    $installmentNo = $this::installmentNo();
                    // تقسيم مبلغ وفترة الإيجار بحسب عدد الأقساط وإضافتها لجدول الأقساط
                    $patrt_installment = $this::Partinstallment($model);
                    for ($i = 0; $i < $model->number_installments; $i++) {
                        $installments = new Installment;
                        $installments->contract_id = $model->id;
                        $installments->renter_id = $renter->id;
                        $installments->installment_no = (string)$installmentNo++;
                        $installments->amount = $patrt_installment[$i]['amount'];
                        $installments->start_date = $patrt_installment[$i]['start_date'];
                        $installments->end_date = $patrt_installment[$i]['end_date'];
                        $installments->save();
                    }

                    $model->trigger(Contract::EVENT_STATEMENT);

                    if (isset($request->post()['generate-installment'])) {
                        return $this->redirect(['/installment/generate-installment', 'contract_id' => $model->id]);
                    }

                    $session = Yii::$app->session;
                    unset($session['housing_unit']);
                    unset($session['owner_identity_id']);
                    unset($session['renter_identity_id']);

                    Yii::$app->session->setFlash('success', Yii::t('app', 'New Contract Added successfully.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            return $this->renderAjax('/contract/_add_contract', [
                'model' => $model,
                'owner' => $owner,
                'arrImages2' => $arrImages2,
                'renter' => $renter,
            ]);

        }

        /*
        *   Process for non-ajax request
        */
        return $this->redirect('create');
    }

    public function actionIndex()
    {
        $searchModel = new ContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {

        $session = Yii::$app->session;
        $test = GeneralHelpers::testActiveEstateOffice();

        if ($test == false) {

            Yii::$app->session->setFlash('danger', Yii::t('app', 'You cannot add a contract due to the expiration of your subscription date or the expiration of the contract balance'));
            return $this->redirect('index');

        } else {

            return $this->render('create');
        }
    }

    /**
     * Displays a single Building model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'contract' => $this->findModel($id),
        ]);
    }

    public function actionDownload($id, $type = null)
    {
        $model = $this->findModel($id);
        $content = Yii::$app->request->post('image', '');
        $title = Yii::t('app', 'Renter Contract') . ' ' . $model->contract_no;
        return \backend\controllers\InstallmentController::down($content, $title);
    }

    /**
     * Creates a new Building model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('/contract/update')) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $owner = $model->owner;
        $renter = $model->renter;
        $housing = $model->housingUnit;
        $arrImages2 = GeneralHelpers::updateImages($model);

        if ($model->load($request->post()) && $model->validate()) {

            // إذا كان ات الوحدة تجارية يتم احتسا الضريبة من الاعدادات العامة
            if ($housing->using_for == 1) {
                $added_tax_setting = yii::$app->SiteSetting->info()->added_tax;
                if ($added_tax_setting > 0 && $model->price > 0)
                    $model->added_tax = round(($added_tax_setting * $model->price) / 100, 2);
            }

            if ($model->include_water == 1 && $model->water_amount > 0) {
                $model->price = $model->price + $model->water_amount;
            }

            // إذا كانت مسودة
            if (isset($request->post()['is_draft'])) {
                $model->is_draft = 1;
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Contract Saved As Draft.'));
                GeneralHelpers::setImages($model);

                return $this->redirect(['index']);
            }

            if ($model->is_draft === 1) {

                $housing->status = 1;
                $housing->save(false);

                $model->is_draft = 0;
                $model->contract_no = $this::ContractNo();
                $estatOffice = \common\models\EstateOffice::findOne($model->estate_office_id);
                $estatOffice->contract_balance -= 1;
                $estatOffice->save(false);


                $installmentNo = $this::installmentNo();
                // تقسيم مبلغ وفترة الإيجار بحسب عدد الأقساط وإضافتها لجدول الأقساط
                $patrt_installment = $this::Partinstallment($model);
                for ($i = 0; $i < $model->number_installments; $i++) {
                    $installments = new Installment;
                    $installments->contract_id = $model->id;
                    $installments->renter_id = $renter->id;
                    $installments->installment_no = (string)$installmentNo++;
                    $installments->amount = $patrt_installment[$i]['amount'];
                    $installments->start_date = $patrt_installment[$i]['start_date'];
                    $installments->end_date = $patrt_installment[$i]['end_date'];
                    $installments->save();
                }
                if (isset($request->post()['generate-installment'])) {
                    return $this->redirect(['/installment/generate-installment', 'contract_id' => $model->id]);
                }
                $model->trigger(Contract::EVENT_NEW);
                $model->trigger(Contract::EVENT_STATEMENT);

            }
            $model->save();
            GeneralHelpers::setImages($model);

            Yii::$app->session->setFlash('success', Yii::t('app', 'Contract Updated successfully.'));
            return $this->redirect(['index']);

        } else {
            // print_r($model->getErrors()); die();
            return $this->render('update', [
                'model' => $model,
                'owner' => $owner,
                'arrImages2' => $arrImages2,
                'renter' => $renter,
            ]);
        }

    }

    public function actionEnding($id)
    {
        $model = $this->findModel($id);

        if ($model->is_active === 0) {
            Yii::$app->session->setFlash('danger', yii::t('app', "This Contract is Ended"));
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->trigger(Contract::EVENT_EXPIRED);
        Yii::$app->session->setFlash('success', Yii::t('app', 'The Contract has been successfully Ended'));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRenew($id)
    {
        $test = GeneralHelpers::testActiveEstateOffice();
        if ($test == false) {
            Yii::$app->session->setFlash('danger', Yii::t('app', 'You cannot add a contract due to the expiration of your subscription date or the expiration of the contract balance'));
            return $this->redirect(['/contract/index']);
        }

        $model = $this->findModel($id);
        if ($model->housingUnit->status == 1) {
            Yii::$app->session->setFlash('danger', yii::t('app', "you can`t Renew Cotract ,because The Housing Units is Rented"));
            return $this->redirect(['/contract/index']);
        }

        $newModel = new Contract();
        $newModel->attributes = $model->attributes;
        $newModel->user_created_id = Yii::$app->user->identity->id;
        $newModel->is_draft = 1;
        $newModel->refrence_contract_id = $model->id;
        $newModel->contract_no = '';
        $newModel->created_date = null;
        $newModel->number_installments = 2;
        $newModel->save();

        return $this->redirect(['update', 'id' => $newModel->id]);

    }

    public function actionContractForm($cont_form_id)
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $contForm = ContractFormEstateOffice::find()->where(['id' => $cont_form_id, 'estate_office_id' => $estate_office_id])->one();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($contForm) {
            return [
                'error' => false,
                'content' => $contForm->_text,
            ];
        }

        return ['error' => true,
            'content' => '',
        ];
    }


    public static function ContractNo()
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();
        $contract_no = \mdm\autonumber\AutoNumber::generate($estate_office_id . '-?', false, null, ['value' => 'contract-' . $estate_office_id]);

        return $contract_no;
    }

    public static function installmentNo()
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();
        $installment = Installment::find()->joinWith(['contract'])->where(['contract.estate_office_id' => $estate_office_id])->select(['installment.installment_no'])->orderBy(['installment.installment_no' => SORT_DESC])->One();
        if ($installment) {
            return (string)++$installment->installment_no;
        } else {
            return (string)1;
        }
    }

    public static function Partinstallment($model)
    {
        $number = $model->number_installments;

        $date1 = $model->start_date;
        $date2 = $model->end_date;

        $diff = strtotime($date2) - strtotime($date1);
        $days = abs(round($diff / 86400));
        $daysAddToEndDate = (int)5;
        $daysForPart = abs(round($days / $number));
        $start = strtotime($date1);
        $end = strtotime(date('Y-m-d', $start) . " +$daysAddToEndDate day");

        $parts = [];
        for ($i = 0; $i < $number; $i++) {
            $parts[$i] = [
                'amount' => $model->price / $number,
                'start_date' => date('Y-m-d', $start),
                'end_date' => date('Y-m-d', $end),
            ];
            $start = strtotime(date('Y-m-d', $start) . " +$daysForPart day");
            $end = strtotime(date('Y-m-d', $start) . " +$daysAddToEndDate day");
        }
        return $parts;

    }

    public static function getOwner()
    {
        $session = Yii::$app->session;
        if (yii::$app->user->identity->user_type === 'owner_estate_officer') {
            $owner = User::findOne(yii::$app->user->identity->id);
            return $owner;
        }
        if (!isset($session['owner_identity_id'])) {
            $session = Yii::$app->session;
            $session['owner_identity_id'] = null;
            return null;
        }

        return User::find()->where(['identity_id' => $session['owner_identity_id']])->AndWhere(['or', ['user_type' => 'owner'], ['owner' => 1]])->One();

    }

    public static function getHousing()
    {
        $session = Yii::$app->session;
        if (!isset($session['housing_unit'])) {
            $session = Yii::$app->session;
            $session['housing_unit'] = null;
            return null;
        }

        return \common\models\BuildingHousingUnit::findOne($session['housing_unit']);

    }


    public function actionHousingPrice($housing_id)
    {
        $housing = \common\models\BuildingHousingUnit::findOne(['id' => $housing_id]);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($housing) {
            return [
                'error' => false,
                'content' => $housing->rent_price
                // 'price'=>$housing->price,
            ];
        }

        return ['error' => true,
            'content' => '',
        ];
    }

    public static function getRenter()
    {
        $session = Yii::$app->session;
        if (!isset($session['renter_identity_id'])) {
            $session = Yii::$app->session;
            $session['renter_identity_id'] = null;
            return null;

        }

        return User::find()->where(['identity_id' => $session['renter_identity_id']])->AndWhere(['or', ['user_type' => 'renter'], ['renter' => 1]])->One();

    }

    public function actionToStep($owner_identity_id, $renter_identity_id, $housing_unit, $step = 3)
    {
        $session['renter_identity_id'] = $renter_identity_id;
        $session['housing_unit'] = $housing_unit;
        $session['owner_identity_id'] = $owner_identity_id;

        return $this->redirect(['step', 'step' => $step]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Building model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Building the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->can('/contract/update')) {
            $model = Contract::find()->where(['id' => $id])->withDraft()->currentOffice()->one();
        } else {
            $model = Contract::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteFile($id, $attribute = "file")
    {
        return GeneralHelpers::deleteImages(Contract::class, $id, $attribute);
    }
}
