<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use johnitvn\ajaxcrud\CrudAsset; 
use yii\bootstrap\Modal;

CrudAsset::register($this);
$setting = yii::$app->SiteSetting->info();

$this->registerCssFile('@web/css/custome.css', ['depends' => [airani\AdminLteRtlAsset::class]]);

$this->title = Yii::t('app','Sign In');
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    
  <div class="login-logo">
    <img src="<?= $setting->logo ?>" alt="Site Logo" style="max-width: 150px" />
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
     <fieldset>
        <legend><?=Yii::t('app','Sign In')?></legend>
        <div class='col-sm-12'>
        <?php $form = ActiveForm::begin(['id' => 'login-form','class'=>'form-horizontal', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('app','Remember Me')) ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton(Yii::t('app','Sign In'), ['class' => 'btn btn-primary btn-flat', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>
            <div class="row text-right">
                <a href="<?=Yii::$app->homeUrl?>site/request-password-reset" class=" control-label forget-pass"><?= yii::t('app','Lost your password ?');?></a>
                <p class="mb-25 control-label"><?= yii::t('app','Need new verification email?');?> <a href="<?=Yii::$app->homeUrl?>site/resend-verification-email"><?= yii::t('app','Click here');?></a></p>   
            </div>

                <?php Modal::begin([
                    "id"=>"ajaxCrudModal",
                    "footer"=>"",// always need it for jquery plugin
                ])?>
                <?php Modal::end(); ?>
                <?=Html::activeHiddenInput($model, "agreeTerm"); ?>
        </div>
    </fieldset>
        <?php ActiveForm::end(); ?> 

    </div>
</div>
<?php 
$script = <<< JS
$(document).ready(function(){
     modal = new ModalRemote('#ajaxCrubModal');
});
JS;
$this->registerJs($script);
?>