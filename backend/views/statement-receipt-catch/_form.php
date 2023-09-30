<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StatementReceiptCatch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="statement-receipt-catch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount_paid')->textInput() ?>

    <?= $form->field($model, 'estate_office_id')->textInput() ?>

    <?= $form->field($model, 'owner_id')->textInput() ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'detail_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
