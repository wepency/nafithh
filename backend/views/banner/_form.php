<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Url')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <?php /*
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title En')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'title_en')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Text')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Text En')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'text_en')->textarea(['rows' => 6])->label(false) ?>
                </div>
                */ ?>
                <div class='clearfix'></div>

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
                                    'deleteUrl' => Url::to(['attachment/delete-file', 'id' => $model->id, 'attribute' => 'image','className' => $model::class]),
                            ],
                        ])->label(false);  ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status')?></label>
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
