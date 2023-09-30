<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogMessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sender_id') ?>

    <?= $form->field($model, 'sender_type') ?>

    <?= $form->field($model, 'notif_temp_id') ?>

    <?= $form->field($model, 'receiver_id') ?>

    <?php // echo $form->field($model, 'receiver_type') ?>

    <?php // echo $form->field($model, 'contact_mobile') ?>

    <?php // echo $form->field($model, 'contact_email') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
