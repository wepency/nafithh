<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = yii::t('app','Signup');
?>

<!-- Start PagePanner Section -->
<?=Yii::$app->view->renderFile('@frontend/views/site/banner-sec.php');?>

    <!-- Start Login Section -->
    <section class="login-sec site-content">
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
                                <label><?=Yii::t('app','Username')?></label>
                                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Username'),'class'=>'form-control'])->label(false) ?>
                            </div>

                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Name')?></label>
                                <?= $form->field($model, 'name')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Name'),'class'=>'form-control'])->label(false) ?>
                            </div>

                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Email')?></label>
                                <?= $form->field($model, 'email')->textInput(['placeholder'=>Yii::t('app','Email'),'class'=>'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Create Password')?></label>
                                <?= $form->field($model, 'password')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Create Password'),'class'=>'form-control'])->label(false)->passwordInput() ?>
                            </div>
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Confirm Password')?></label>
                                <?= $form->field($model, 'newPasswordConfirm')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Confirm Password'),'class'=>'form-control'])->label(false)->passwordInput() ?>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label><?=yii::t('app','Verify Code')?><strong> * </strong></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                                            ])->label(false) ?>
                                                
                                    </div>
                                </div>
                            </div>
                            <p class="mb-25"><?= yii::t('app','If you have a user you can');?> <a href="<?=Yii::$app->homeUrl?>site/login"><?= yii::t('app','Login');?></a></p>
                            <div class="text-center">
                                <?= Html::submitButton(yii::t('app','Signup'), ['class' => 'btn btn-primary custom-btn', 'name' => 'signup-button']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login Section -->
