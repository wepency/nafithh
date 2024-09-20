<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('app','Login');

?>
<!-- Start PagePanner Section -->
<?=Yii::$app->view->renderFile('@frontend/views/site/banner-sec.php');?>

    <!-- Start Login Section -->
    <section class="login-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="login-div">
                        <?php if (Yii::$app->session->hasFlash('success')){ ?>
                          <div class="alert alert-success alert-dismissable">
                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                               <?=Yii::$app->session->getFlash('success')?>
                          </div>
                        <?php }?>
                        <?php $form = ActiveForm::begin([
                            'options' => ['method' => 'post','class'=>'contact-frm'],
                        ]); ?> 
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','username or email')?></label>
                                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','username or email'),'class'=>'form-control'])->label(false) ?>
                            </div>

                           
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Password')?></label>
                                <?= $form->field($model, 'password')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','password'),'class'=>'form-control'])->label(false)->passwordInput() ?>
                            </div>
                            <div class="row mb-25">
                                <div class="col-md-6 col-12">
                                    <div class="custom-control custom-checkbox">
                                        <?= $form->field($model, 'rememberMe')->checkbox()->label( yii::t('app','Remember Me')) ?> 
                                    </div>  
                                </div>
                                <div class="col-md-6 col-12 text-left">
                                    <a href="<?=Yii::$app->homeUrl?>site/request-password-reset" class="forget-pass"><?= yii::t('app','Lost your password ?');?></a>   
                                </div>
                            </div>
                            <p class="mb-25"><?= yii::t('app','If you are a new user you can');?> <a href="<?=Yii::$app->homeUrl?>site/signup"><?= yii::t('app','Signup');?></a></p>
                            <p class="mb-25"><?= yii::t('app','Need new verification email?');?> <a href="<?=Yii::$app->homeUrl?>site/resend-verification-email"><?= yii::t('app','Click here');?></a></p>
                            <div class="text-center">
                                <?= Html::submitButton(yii::t('app','Login'), ['class' => 'btn btn-primary custom-btn', 'name' => 'signup-button']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login Section -->
