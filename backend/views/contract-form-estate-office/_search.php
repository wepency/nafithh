<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContractFormEstateOfficeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-form-estate-office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'estate_office_id') ?>

    <?= $form->field($model, 'contract_form_id') ?>

    <?= $form->field($model, 'contract_form_name') ?>

    <?= $form->field($model, 'contract_form_name_en') ?>

    <?php // echo $form->field($model, 'contract_form_text') ?>

    <?php // echo $form->field($model, 'contract_form_text_en') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
