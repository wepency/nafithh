<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Name')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Content')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'content')->textarea(['rows' => 6])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Mobile')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Email')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Company Name')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'company_name')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Plan ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'plan_id')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'status')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Response By')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'response_by')->textInput()->label(false) ?>
                </div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
