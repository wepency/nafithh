<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTempEstateOffice */
/* @var $form yii\widgets\ActiveForm */
if(Yii::$app->language == 'ar')
$hint = $model->notification->hint;
else
$hint = $model->notification->hint_en;



?>

<div class="notif-temp-estate-office-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">

		<fieldset>
		   <div class='col-sm-12'>
		   		<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Name')?></label>
                <div class='col-sm-4'>
                    <label class='label-data'><?= $model->name ?></label>

                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Name En')?></label>
                <div class='col-sm-4'>
                    <label class='label-data'><?= $model->name_en ?></label>

                </div>
				<div class="clearfix"></div>

		   		<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title Email')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'title_email')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title Email En')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'title_email_en')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Body Email')?></label>
				<div class='col-sm-10'>
				<?= $form->field($model, 'body_email')->textarea(['rows' => 6])->label(false)->hint($hint) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Body Email En')?></label>
				<div class='col-sm-10'>
				<?= $form->field($model, 'body_email_en')->textarea(['rows' => 6])->label(false)->hint($hint) ?>
				</div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Body Sms')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'body_sms')->textarea(['rows' => 6])->label(false)->hint('<span id="chars"></span> '.yii::t('app','character')) ?>
				
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Body Sms En')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'body_sms_en')->textarea(['rows' => 6])->label(false)->hint('<span id="chars"></span> '.yii::t('app','character')) ?>
				</div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Enable Sms')?></label>
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->enable_sms=0:$model->enable_sms;?>
					<?= $form->field($model, 'enable_sms')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Enable Email')?></label>
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->enable_email=0:$model->enable_email;?>
					<?= $form->field($model, 'enable_email')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
				</div>

            </div>
        </fieldset>	
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = <<< JS
$(document).ready(function(){
	$( "textarea[name*='body_sms']" ).each( function( index, element ){
	  	var label = $(this).next().find("#chars");
	  	label.text($(this).val().length);
		$(this).keyup(function(e) {
			 var length = $(this).val().length;
		  	var length = length;
		  	label.text(length);
			
		});
	});
});
JS;
$this->registerJs($script);
?>