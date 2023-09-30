<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucherSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-voucher-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'recipient_type') ?>

    <?= $form->field($model, 'owner_id') ?>

    <?= $form->field($model, 'estate_office_id') ?>

    <?= $form->field($model, 'building_housing_unit_id') ?>

    <?php // echo $form->field($model, 'maintenance_office_id') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'amount_text') ?>

    <?php // echo $form->field($model, 'receipt_voucher_no') ?>

    <?php // echo $form->field($model, 'pay_against') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'user_receipt_id') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'details') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
