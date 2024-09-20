<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('app','Ching your password');

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
?>
<div class="login-box">
    
    <div class="login-logo">
        <a href="#"><b>AQAR</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

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

        <p class="login-box-msg"><?=Yii::t('app','Ching your password')?></p>
        <p> <?=yii::t('app','You can change the new password by writing it down with its confirmation')?></p>

                
        <?php $form = ActiveForm::begin(['options' => ['method' => 'post']]); ?>
            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->textInput(['autofocus' => true,'placeholder' => $model->getAttributeLabel('password')])->passwordInput() ?>
             <?= $form
                ->field($model, 'newPasswordConfirm', $fieldOptions2)
                ->label(false)
                ->textInput(['placeholder'=>Yii::t('app','Confirm Password')])->passwordInput() ?>
           
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-6">
                    <?= Html::submitButton(yii::t('app','Save'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>