<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StatementReceiptCatchSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="statement-receipt-catch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'amount_paid') ?>

    <?= $form->field($model, 'estate_office_id') ?>

    <?= $form->field($model, 'owner_id') ?>

    <?= $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'detail_en') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
