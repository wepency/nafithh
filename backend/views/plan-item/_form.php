<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PlanItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-item-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title En')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'title_en')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Plan ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'plan_id')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sort At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'sort_at')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
