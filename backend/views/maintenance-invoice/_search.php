<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceInvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintenance-invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_from') ?>

    <?= $form->field($model, 'date_to') ?>

    <?= $form->field($model, 'total_amount') ?>

    <?= $form->field($model, 'commission_percent') ?>

    <?php // echo $form->field($model, 'commission_amount') ?>

    <?php // echo $form->field($model, 'office_earnings') ?>

    <?php // echo $form->field($model, 'office_id') ?>

    <?php // echo $form->field($model, 'user_created_id') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
