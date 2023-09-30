<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('app','Forget your password');
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

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

        <p class="login-box-msg"><?=Yii::t('app','Forget your password')?></p>
                           
        <?php $form = ActiveForm::begin(['options' => ['method' => 'post']]); ?>
            <?= $form
                ->field($model, 'email', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-6">
                    <?= Html::submitButton(yii::t('app','Reset your password'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>