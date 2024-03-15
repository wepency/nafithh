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
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Link') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'link')->textInput(['maxlength' => true])->label(false) ?></div>

            </div>

            <div class='col-sm-12'>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'adLicenseNumber') ?></label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'adLicenseNumber')->textInput(['maxlength' => true])->label(false) ?>
                </div>

            </div>

            <div class='col-sm-12'>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'advertiserId') ?></label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'adLicenseId')->textInput(['maxlength' => true])->label(false) ?>
                </div>

            </div>

            <div class="col-sm-12">
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'adType') ?></label>

                <div class="col-sm-4">
                    <?= $form->field($model, 'idType', ['options' => ['class' => 'form-group']])->label(false)->dropDownList([
                        '1' => Yii::t('app', 'adTypeRent'),
                        '2' => Yii::t('app', 'adTypeSale'),
                    ], ['prompt' => Yii::t('app', 'Select an option'), 'class' => 'form-control']) ?>
                </div>

            </div>

		    <div class='col-sm-12'>
			<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Image') ?> </label>
				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'image')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->image) ? $model->image : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['ad/delete-file', 'id' => $model->id]),
							],
						])->label(false)->hint("<label>".yii::t('app','Height: 230px')."</label>");  ?>
				</div>

            </div>

            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'View In Page') ?> </label> 
            <div class='col-sm-4'>
                <?php $model->isNewRecord ? $model->page_name='home':$model->page_name;?>
                <?= $form->field($model, 'page_name')->radioList(Yii::$app->params['pageName'][Yii::$app->language])->label(false) ?>
            </div>

			<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 
			<div class='col-sm-4'>
				<?php $model->isNewRecord ? $model->status=1:$model->status;?>
				<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
			</div>
	     </fieldset>
    </div>
		
    
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
