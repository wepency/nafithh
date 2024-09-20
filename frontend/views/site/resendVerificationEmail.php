<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('app','Resend verification email');


?>
   <!-- render image banner for accounts page -->
<?=Yii::$app->view->renderFile('@frontend/views/site/banner-sec.php');?>

    <!-- Start Login Section -->
    <section class="login-sec site-content ">
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
                        <?php if (Yii::$app->session->hasFlash('error')){ ?>
                          <div class="alert alert-warning alert-dismissable">
                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                               <?=Yii::$app->session->getFlash('error')?>
                          </div>
                        <?php }?>
                        <p> <?=yii::t('app','We will send a link to your email to activate your account')?></p>
                        <div class="div-30"></div>
                        <?php $form = ActiveForm::begin([
                            'options' => ['method' => 'post','class'=>'contact-frm'],
                            ]); ?>
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Email')?></label>
                                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Email'),'class'=>'form-control'])->label(false) ?>
                            </div>
                            <div class="div-30"></div>
                            <div class="text-center">
                                <?= Html::submitButton(yii::t('app','Resend verification email'), ['class' => 'btn btn-primary custom-btn', 'name' => 'signup-button']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login Section -->
