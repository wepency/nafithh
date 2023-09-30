<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RentPeriod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rent-period-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 

				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
				</div>
            </div>
	    </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
