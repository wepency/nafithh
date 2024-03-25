<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Ad;
use common\models\Installment;
use common\models\MaintenanceOffice;
use common\models\User;
use common\models\BuildingHousingUnit;
use common\models\HousingUnitType;
use common\models\Contract;
use common\models\OrderMaintenance;
use common\models\EstateOffice;
use common\models\Building;
use common\models\BuildingType;
use common\models\Chat;
use common\models\SystemExpense;
use common\models\SystemIncome;
use frontend\models\LoginForm;
use common\models\UserEstateOffice;
use yii\web\Cookie;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use yii\helpers\Html;
use yii\db\Expression;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'=>['request-password-reset','reset-password','verify-email','resend-verification-email'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'login-as' => ['post'],
                    'login-as-user' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    
    public function actionIndex()
    {
        new \common\components\MultiUserType();
        $infoUser = \common\models\Chat::getInfoUser();
        $option = [];
        $other =null;
        switch ($infoUser["userType"]) {
            case 'owner':
                $option = $this->dashboardOwner($infoUser["userId"]);
                break;
            case 'renter':
                $option = $this->dashboardRenter($infoUser["userId"]);
                break;
            case 'admin':
                $option = $this->dashboardAdmin($infoUser["userId"]);
                break;
            case 'estate_officer':
                $option = $this->dashboardEstate($infoUser["userId"]);
                break;
            case 'maintenance_officer':
                $option = $this->dashboardMaintenance($infoUser["userId"]);
                break;
            default:
                $other = true;
                break;
        }
        if($other || !is_array($option))
            return $this->render("index");
        else{
            $option = array_merge($option,["type"=> $infoUser["userType"]]);
            return $this->render('/dashboard/index',['option' =>$option]);
        }
    }

    public function actionLanguage()
    {

       $language = Yii::$app->request->get('language');
        Yii::$app->language = $language;

        $languageCookie = new Cookie([
            'name' => 'language',
            'value' => $language,
            'expire' => time() + 60 * 60 * 24 * 30, // 30 days
        ]);

        Yii::$app->response->cookies->add($languageCookie);

        return $this->redirect(Yii::$app->request->referrer);

    }


    private function dashboardOwner($id)
    {
        $countContractOpen = Contract::find()->where(['owner_id'=> $id])->active()->count();
        $countContractClose = Contract::find()->where(['owner_id'=> $id])->active('false')->count();

        $buildingIds = Building::find()->select(['id'])->where(['owner_id'=> $id])->asArray()->all();
        $buildingIds = ArrayHelper::getColumn($buildingIds, 'id');

        $building = Building::find()->select(['building_type_id','count(*) as countbuilding'])->where(['id'=>$buildingIds])->groupBy(['building_type_id'])->orderBy(['countbuilding'=> SORT_DESC])->limit(10)->asArray()->all();
        $buildingType = BuildingType::getBuildingTypeName();


        $housing = BuildingHousingUnit::find()->select(['building_type_id','count(*) as count'])->where(['building_id'=>$buildingIds])->groupBy(['building_type_id'])->limit(10)->orderBy(['count'=> SORT_DESC])->asArray()->all();
        $housingType = $buildingType;

        $chat = Chat::find()->CurrentUser()->orderBy(['id'=> SORT_DESC])->all();

        $dataIds = OrderMaintenance::find()->select(['order_maintenance.id','order_info_id'])->where(['sender_id' => $id ,'sender_type'=>'owner'])->joinWith(['orderInfo'])->asArray()->all();
        $dataIds = ArrayHelper::getColumn($dataIds, 'id');
        $order = OrderMaintenance::find()->where(['id' => $dataIds])->select(['status','count(*) as count'])->groupBy(['status'])->orderBy(['count'=> SORT_DESC])->asArray()->all();
        $orderType = Yii::$app->params['statusOrder'][Yii::$app->language];

        $InstaIds = Installment::find()->joinWith(['contract'])->select(['installment.id','contract_id'])->where(['contract.owner_id' => $id])->asArray()->all();
        $InstaIds = ArrayHelper::getColumn($InstaIds, 'id');
        $InstaAll = count($InstaIds);
        // $InstaEnd->select(['DATE_FORMAT(installment.start_date, "%d-%m-%Y") as endDate'])->where(['>=','start_date',date("Y-m-d")])->one();
        $InstaEnd= Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['<','installment.start_date',date("Y-m-d")])->count();
        $InstaInMonth = Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['=','DATE_FORMAT(installment.start_date, "%Y-%m")',date("Y-m")])->count();
        $ads = Ad::find()->where(['status'=>1,'page_name'=>'owner'])->orderby('id DESC')->all();

        // $Installment = Installment::find()->where(['id'=>$InstaIds])->groupBy(['building_type_id'])->orderBy(['countbuilding'=> SORT_DESC])->limit(10)->asArray()->all();

        // $countMaintenance = MaintenanceOffice::find()->count();

        // $recipit = MaintenanceOffice::find()->count();
       return compact('countContractOpen','countContractClose','building','buildingType','housing','housingType','chat','InstaAll','InstaEnd','InstaInMonth','order','orderType','ads');


    }

    private function dashboardRenter($id)
    {
        $countContractOpen = Contract::find()->where(['renter_id'=> $id])->active()->count();
        $countContractClose = Contract::find()->where(['renter_id'=> $id])->active('false')->count();

        $chat = Chat::find()->CurrentUser()->orderBy(['id'=> SORT_DESC])->all();

        $dataIds = OrderMaintenance::find()->select(['order_maintenance.id','order_info_id'])->where(['sender_id' => $id ,'sender_type'=>'renter'])->joinWith(['orderInfo'])->asArray()->all();
        $dataIds = ArrayHelper::getColumn($dataIds, 'id');
        $order = OrderMaintenance::find()->where(['id' => $dataIds])->select(['status','count(*) as count'])->groupBy(['status'])->orderBy(['count'=> SORT_DESC])->asArray()->all();
        $orderType = Yii::$app->params['statusOrder'][Yii::$app->language];

        $InstaIds = Installment::find()->where(['renter_id'=> $id])->select(['installment.id'])->asArray()->all();
        $InstaIds = ArrayHelper::getColumn($InstaIds, 'id');
        $InstaAll = count($InstaIds);
        $InstaEnd= Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['<','installment.start_date',date("Y-m-d")])->count();
        $InstaInMonth = Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['=','DATE_FORMAT(installment.start_date, "%Y-%m")',date("Y-m")])->count();

        $ads = Ad::find()->where(['status'=>1,'page_name'=>'renter'])->orderby('id DESC')->all();


       return compact('countContractOpen','countContractClose','chat','InstaAll','InstaEnd','InstaInMonth','order','orderType','ads');

    }

    private function dashboardAdmin()
    {
        $countMaintenance = MaintenanceOffice::find()->count();
        $countEstate = EstateOffice::find()->count();
        $countEstateExpaire = EstateOffice::find()->where(['<=','expire_date',date("Y-m-d")])->count();
        $countOwner = User::find()->where(['or',['user_type'=>'owner'],['owner'=>1]])->count();
        $countRenter = User::find()->where(['or',['user_type'=>'renter'],['renter'=>1]])->count();

        $building = Building::find()->select(['building_type_id','count(*) as countbuilding'])->groupBy(['building_type_id'])->limit(10)->orderBy(['countbuilding'=> SORT_DESC])->asArray()->all();
        $buildingType = BuildingType::getBuildingTypeName(); 

        $chat = Chat::find()->CurrentUser()->orderBy(['id'=> SORT_DESC])->all();
        $countNewChat = Chat::find()->joinWith(['chatHistories' => function($query) {
            $query->unread();
        }])->CurrentUser()->count();
            // print_r($countNewChat);die();
        $blackList = User::find()->where(['And',['or',['in','user_type',['owner','renter']],['owner'=>1,'renter'=>1]],['black_list'=>1]])->limit(3)->all();
        $contracts = Contract::find()
                ->select(['estate_office_id', 'count(*) as count', 'sum(price) as amounts'])
                ->groupBy ('estate_office_id')->orderBy(['amounts'=> SORT_DESC])->asArray()->limit(5)->all();

        $estateOfficeIds = Arrayhelper::map($contracts, 'estate_office_id', 'estate_office_id');

        $estateOfficeNames = Arrayhelper::map(EstateOffice::find()->where(['id' => $estateOfficeIds])->asArray()->all(),"name","name") ;

        $expense = SystemExpense::find()->select(['sum(amount) as amount'])->asArray()->all();
        $income = SystemIncome::find()->select(['sum(amount) as amount'])->asArray()->all();
        return compact('countMaintenance','countEstate','countEstateExpaire','countOwner','countRenter','building','buildingType','chat','countNewChat','blackList','contracts','estateOfficeNames','expense','income');


    }

    private function dashboardEstate($id)
    {
        $estate_office_id = $id;
        $countOwner = User::find()->where(['estate_office_id' => $estate_office_id])->AndWhere(['or',['user_type'=>'owner'],['owner'=>1]])->leftJoin('estate_office_owner', 'user.id = estate_office_owner.owner_id')->count();
        $countContractOpen = Contract::find()->currentOffice($estate_office_id)->withDraft()->active()->count();
        $countContractClose = Contract::find()->currentOffice($estate_office_id)->withDraft()->active(0)->count();

        $buildingIds = Building::find()->select(['building.id'])->leftJoin('estate_office_building as eob','building.id = eob.building_id'
            )->where(['estate_office_id'=> $estate_office_id,'is_active'=>1])->asArray()->all();
        $buildingIds = ArrayHelper::getColumn($buildingIds, 'id');

        $building = Building::find()->select(['building_type_id','count(*) as countbuilding'])
        ->where(['id'=>$buildingIds])->groupBy(['building_type_id'])->orderBy(['countbuilding'=> SORT_DESC])->limit(10)->asArray()->all();
        $buildingType = BuildingType::getBuildingTypeName();


        $housing = BuildingHousingUnit::find()->select(['building_type_id','count(*) as count'])->where(['building_id'=>$buildingIds])->groupBy(['building_type_id'])->limit(10)->orderBy(['count'=> SORT_DESC])->asArray()->all();
        $housingType = $buildingType; 

        $chat = Chat::find()->CurrentUser()->orderBy(['id'=> SORT_DESC])->all();

        $InstaIds = Installment::find()->joinWith(['contract'])->select(['installment.id','contract_id'])->where(['contract.estate_office_id' => $estate_office_id])->asArray()->all();
        $InstaIds = ArrayHelper::getColumn($InstaIds, 'id');
        $InstaAll = count($InstaIds);
        // $InstaEnd->select(['DATE_FORMAT(installment.start_date, "%d-%m-%Y") as endDate'])->where(['>=','start_date',date("Y-m-d")])->one();
        $InstaEnd= Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['<','installment.start_date',date("Y-m-d")])->count();
        $InstaInMonth = Installment::find()->where(['id'=>$InstaIds,'payment_status'=>Installment::STATUS_UNPAID])->andWhere(['=','DATE_FORMAT(installment.start_date, "%Y-%m")',date("Y-m")])->count();

         $ads = Ad::find()->where(['status'=>1,'page_name'=>'estate_officer'])->orderby('id DESC')->all();

        // print_r(date("Y-m")); 
        // die();
        // $db = Yii::$app->getDb();
        // list($sql, $params) = $db->getQueryBuilder()->build($InstaInMonth);
        // $command = $db->createCommand($sql, $params);
        // $rawsql = $command->getRawsql();
        // print_r($rawsql); 

        // $countMaintenance = MaintenanceOffice::find()->count();

        // $recipit = MaintenanceOffice::find()->count();
       return compact('countOwner','countContractOpen','countContractClose','building','buildingType','housing','housingType','chat','InstaAll','InstaEnd','InstaInMonth','ads');

    }

    private function dashboardMaintenance($id)
    {
        $dataIds = OrderMaintenance::find()->select(['id'])->where(['maintenance_office_id' => $id ])->asArray()->all();
        $dataIds = ArrayHelper::getColumn($dataIds, 'id');

        $countOrderClose = OrderMaintenance::find()->where(['id' => $dataIds,'status' => 10])->count();
        $countOrderOpen = OrderMaintenance::find()->where(['id' => $dataIds])->andWhere(['!=','status',10])->count();

        $order = OrderMaintenance::find()->where(['id' => $dataIds])->select(['status','count(*) as count'])->groupBy(['status'])->orderBy(['count'=> SORT_DESC])->asArray()->all();
        $orderType = Yii::$app->params['statusOrder'][Yii::$app->language];
        $chat = Chat::find()->CurrentUser()->orderBy(['id'=> SORT_DESC])->all();
        $ads = Ad::find()->where(['status'=>1,'page_name'=>'maintenance_officer'])->orderby('id DESC')->all();

        return compact('countOrderOpen','countOrderClose','order','orderType','chat','ads');


    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                $user = Yii::$app->user->identity;
    			if(isset($user->role) && ($user->role == "estate_officer")){
    				$user_estate = UserEstateOffice::find()->where(['user_id'=>Yii::$app->user->identity->id])->one();
    				$session = Yii::$app->session;
    				$session['estate_office_id'] = $user_estate->estate_office_id;
    			}

                if (Yii::$app->session->has('paymentPlan'))
                    return $this->redirect(Yii::$app->BaseUrl->baseUrl.'/payment/overview');

                return $this->goBack();
            }else{
                if(isset($model->getErrors()['agreeTerm'])){
                    $terms = "<div class=\'box-body table-responsive\'>".yii::$app->SiteSetting->info()->_terms_and_conditions."<br> ".yii::t('app','you have agree to')." ".yii::t('app','Terms And Conditions').'</div>';
                    $footer = Html::Submitbutton(yii::t('app','I\'m Agree'),  [
                            'class' => 'btn btn-group-justified btn-primary center-block',
                            'onclick' => "$('input[name=\"LoginForm[agreeTerm]\"]').val(1)",
                            ]);
                     Yii::$app->view->registerJs("
                        modal.open();
                        modal.hidenCloseButton();
                        modal.setTitle('".yii::t('app','Agree Terms and conditions')."');
                        modal.setContent('".$terms."');
                        modal.setFooter('".$footer."');
                        ");
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                } 
            }
        } 
             
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLoginAs($userType)
    {
        // die();
        \common\components\MultiUserType::loginAs($userType);
        return $this->redirect(['index']);
    }


    public function actionLoginAsUser($user_id)
    {
        if(Yii::$app->user->identity->user_type === 'developer'){
            $user = User::findOne($user_id);
            // print_r(Yii::$app->user::class); die();
            // Yii::$app->user2->enableAutoLogin = false;
            // Yii::$app->session->name = "sdff_fafaf";
            // Yii::$app->user2->login($user);
            Yii::$app->user->login($user);
        }
        return $this->redirect(['index']);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
         return $this->redirect(['../']);
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', yii::t('app', 'Check your email for further instructions.'));
            } else {
                Yii::$app->session->setFlash('error',  yii::t('app','Sorry, we are unable to reset password for the provided email address.'));
            }

            return $this->refresh();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','New password saved.'));

             return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            Yii::$app->session->setFlash('error', Yii::t('app','Sorry, we are unable to verify your account with provided token.'));
        // return $this->goHome();

            return $this->redirect(['resend-verification-email']);
            //throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', Yii::t('app','Your email has been confirmed!'));
                return $this->redirect(['volunteer/basic-data']);
            }
        }

        return $this->redirect(['resendVerificationEmail']);
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->activationCode()) {
            if (User::sendActiveEmail($model->email)) {
               Yii::$app->session->setFlash('success', yii::t('app','Thank you for registration. Please check your inbox for verification email.'));
            }
            Yii::$app->session->setFlash('error', yii::t('app','There was a problem sending your verification code. Please try again'));
            return $this->refresh();

        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
