<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VolCity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vol-city-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
        <fieldset>
		   <div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Name')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Name En')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'status') ?> </label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
				</div>
			</div>
        </fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
