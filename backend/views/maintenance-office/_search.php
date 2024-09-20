<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceOfficeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintenance-office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'logo') ?>

    <?= $form->field($model, 'registration_code') ?>

    <?= $form->field($model, 'auth_person') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'registration_date') ?>

    <?php // echo $form->field($model, 'expire_date') ?>

    <?php // echo $form->field($model, 'status_account') ?>

    <?php // echo $form->field($model, 'sms_balance') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'header_report_image') ?>

    <?php // echo $form->field($model, 'footer_report_image') ?>

    <?php // echo $form->field($model, 'tax_num') ?>

    <?php // echo $form->field($model, 'user_created_id') ?>

    <?php // echo $form->field($model, 'registry_price') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
