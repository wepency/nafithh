<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTempSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notif-temp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'name_en') ?>

    <?= $form->field($model, 'title_email') ?>

    <?= $form->field($model, 'title_email_en') ?>

    <?php // echo $form->field($model, 'body_email') ?>

    <?php // echo $form->field($model, 'body_email_en') ?>

    <?php // echo $form->field($model, 'body_sms') ?>

    <?php // echo $form->field($model, 'body_sms_en') ?>

    <?php // echo $form->field($model, 'enable_sms') ?>

    <?php // echo $form->field($model, 'enable_email') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
