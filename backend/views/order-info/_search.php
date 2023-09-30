<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'maintenance_type_id') ?>

    <?= $form->field($model, 'estate_office_id') ?>

    <?= $form->field($model, 'building_housing_unit_id') ?>

    <?= $form->field($model, 'sender_id') ?>

    <?php // echo $form->field($model, 'sender_type') ?>

    <?php // echo $form->field($model, 'send_to') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'details_order') ?>

    <?php // echo $form->field($model, 'is_draft') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
