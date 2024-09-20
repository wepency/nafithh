<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccountOffice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-account-office-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
		   <div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Bank Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'bank_name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Bank Name En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'bank_name_en')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class='clearfix'></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Account Number') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'account_number')->textInput(['maxlength' => true])->label(false) ?></div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Iban') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'iban')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class='clearfix'></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner Account Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'owner_account_name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner Account Name En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'owner_account_name_en')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class='clearfix'></div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Logo') ?> </label> 

				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'logo')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->logo) ? $model->logo : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['bank-account-office/delete-file', 'id' => $model->id,'logo']),
							],
						])->label(false);  ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 

				<div class='col-sm-10'>
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
