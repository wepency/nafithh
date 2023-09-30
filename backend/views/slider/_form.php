<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\redactor\widgets\Redactor;
/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
		    <div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Title') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Title En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'title_en')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Body') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'text')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Body En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'text_en')
				->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Url') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(false) ?></div>
                <div class="clearfix"></div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Image Or Video') ?> </label> 

				<div class='col-sm-10'>
					<?php
                    $ext = pathinfo($model->image, PATHINFO_EXTENSION);
                    $type = ($ext === 'mp4' || $ext === 'mkv') ?'video' :'image';
                    $mimetype = FileHelper::getMimeTypeByExtension($model->image);

                    // print_r($mimetype); die();
                        echo $form->field($model, 'image')->widget(FileInput::class, [
                            'options' => ['accept' => 'video/*'],
                            'pluginOptions' => [
                                    'allowedPreviewTypes' => ['video'],
                                    'previewFileType' => 'video',
                                    'showUpload' => false,
                                    'resizeImages' => true,
                                    'showRemove' => true,
                                    'initialPreview'=> !empty($model->image) ? [$model->image] : '',
                                    'initialPreviewAsData'=>true,
                                    'initialPreviewConfig' => [
                                    	array('type' => $type, 'filetype' => $mimetype,
                                    'url' => Url::to(['attachment/delete-file', 'id' => $model->id, 'attribute' => 'image','className' => $model::class]))],
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
