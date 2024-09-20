<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SmsProviderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-provider-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'sender') ?>

    <?php // echo $form->field($model, 'sendgrid_username') ?>

    <?php // echo $form->field($model, 'sendgrid_password') ?>

    <?php // echo $form->field($model, 'paypal_type') ?>

    <?php // echo $form->field($model, 'sandbox') ?>

    <?php // echo $form->field($model, 'production') ?>

    <?php // echo $form->field($model, 'sending_status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
