<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;

use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Slider;
use common\models\Gallery;
use common\models\Partner;
use common\models\ContactUs;
use common\models\Ad;
use common\models\Banner;
use common\models\UserEstateOffice;
use common\components\GeneralHelpers;

use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use yii\web\Cookie;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public $enableCsrfValidation = false;

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
     * {@inheritdoc}
     */
	
  public function actionIndex()
    {

        $model = new LoginForm();
		$slider = Slider::find()->where(['status'=>1])->orderby('id DESC')->all();
        $ads = Ad::find()->where(['status'=>1,'page_name'=>'home'])->orderby('id DESC')->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                if(isset(Yii::$app->user->identity->user_type) && (Yii::$app->user->identity->user_type == "estate_officer" || Yii::$app->user->identity->user_type == "sub_estate_officer")){
                    $user_estate = UserEstateOffice::find()->where(['user_id'=>Yii::$app->user->identity->id])->one();
                    $session = Yii::$app->session;
                    $session['estate_office_id'] = $user_estate->estate_office_id;
                }
                return $this->redirect(['/admin']);
            }else{
                if(isset($model->getErrors()['agreeTerm'])){
                    $terms = "<div class=\'box-body table-responsive\'>".yii::$app->SiteSetting->info()->_terms_and_conditions."<br> ".yii::t('app','you have agree to')." ".yii::t('app','Terms And Conditions').'</div>';
                    $footer = Html::Submitbutton(yii::t('app','I\'m Agree'),  [
                            'class' => 'btn btn-block custom-btn',
                            'style' => 'padding: 8px',
                            'onclick' => "$('input[name=\"LoginForm[agreeTerm]\"]').val(1)",
                            ]);
                    Yii::$app->view->registerJs("
                        modal.open();
                        modal.hidenCloseButton();
                        modal.setTitle('".yii::t('app','Agree Terms and conditions')."');
                        modal.setContent('".$terms."');
                        modal.setFooter('".$footer."');
                        ");
                    return $this->render('index',
                    [
                        'slider'=>$slider,  
                        'ads'=>$ads,  
                        'model'=>$model,  
                    ]);
                } 
            }
            $model->password = '';
             //return $this->goHome();
        }

        return $this->render('index',
		[
    		'slider'=>$slider,	
            'model'=>$model,  
            'ads'=>$ads,  
		]);
    }

    public function actionSubscribe()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Maillist();
        $model->load(Yii::$app->request->post());

        if ($model->validate()) {
             $maillist = Maillist::find()->where(['email'=>$model->email])->one();
             if ($maillist===null){
                $model->email = Html::encode($model->email);

                $model->save();

                $response = [
                    'error'=>false,
                    'message' => Yii::t('app','Your subscribe has been done successfully.')
                ];
                       
                return $response; 

             }else{
                return array('error'=>true,'fields'=>['email'=>Yii::t('app','This Email is already exist!')]);
             }
             
             
        }else {
            return array('error'=>true,'fields'=>$model->getErrors());
        }

    }

    /*
    *
    */
   


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
    

    /**
     * Logs in a user.
     *
     * @return mixed
     */

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */

    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->Validate() && $model->signup() ) {
            
            Yii::$app->session->setFlash('success', yii::t('app', 'Check your email for further instructions.'));
            $model = new SignupForm();
            
             return $this->render('signup', [
                'model' => $model,
            ]);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

       /**
     * Requests password reset.
     *
     * @return mixed
     */

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', yii::t('app', 'Check your Mobile for further instructions.'));
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

             return $this->redirect(['index']);
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
            return $this->redirect(['resend-verification-email']);
            //throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', Yii::t('app','Your email has been confirmed!'));
                return $this->redirect(['index']);
            }
        }

        return $this->redirect(['index']);
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
