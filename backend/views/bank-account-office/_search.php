<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccountOfficeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-account-office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'estate_office_id') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?= $form->field($model, 'bank_name_en') ?>

    <?= $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'account_number') ?>

    <?php // echo $form->field($model, 'owner_account_name') ?>

    <?php // echo $form->field($model, 'owner_account_name_en') ?>

    <?php // echo $form->field($model, 'iban') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
