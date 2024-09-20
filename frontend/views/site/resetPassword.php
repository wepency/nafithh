<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('app','Ching your password');


?>
<!-- Start PagePanner Section -->
<?=Yii::$app->view->renderFile('@frontend/views/site/banner-sec.php');?>

    <!-- Start Login Section -->
    <section class="login-sec site-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="login-div">
                        <h4><?=yii::t('app','Ching your password')?></h4>
                        <p> <?=yii::t('app','You can change the new password by writing it down with its confirmation')?></p>
                        <div class="div-30"></div>
                        <?php $form = ActiveForm::begin([
                            'options' => ['method' => 'post','class'=>'contact-frm'],
                            ]); ?>
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Password')?></label>
                                <?= $form->field($model, 'password')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','password'),'class'=>'form-control'])->label(false)->passwordInput() ?>
                            </div>
                            <div class="form-group mb-25">
                                <label><?=Yii::t('app','Confirm Password')?></label>
                                <?= $form->field($model, 'newPasswordConfirm')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','Confirm Password'),'class'=>'form-control'])->label(false)->passwordInput() ?>
                            </div>
                            <div class="div-30"></div>
                            <div class="text-center">
                                <?= Html::submitButton(yii::t('app','Save'), ['class' => 'btn btn-primary custom-btn', 'name' => 'signup-button']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login Section -->
