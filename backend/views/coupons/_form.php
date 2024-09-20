<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>

            <div class='col-sm-12'>

                <label for='coupon' class='col-sm-2 control-label'><?= Yii::t('app', 'Coupon') ?></label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'coupon')->textInput(['maxlength' => true])->label(false) ?>
                </div>

            </div>

            <div class='col-sm-12'>

                <label for='discount' class='col-sm-2 control-label'><?= Yii::t('app', 'discount').' %' ?></label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'discount')->textInput(['type' => 'number', 'max' => 100, 'min' => 0])->label(false) ?>
                </div>

            </div>

	     </fieldset>
    </div>
		
    
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
