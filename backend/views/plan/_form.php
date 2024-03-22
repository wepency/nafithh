<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Plan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-form box box-primary">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['class'=>"form-horizontal"]]); ?>

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

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Image') ?> </label>
                <div class='col-sm-10'>
                    <?php
                        echo $form->field($model, 'image')->widget(FileInput::class, [
                            'options' => ['accept' => 'image/*'],
                            'pluginOptions' => [
                                    'allowedPreviewTypes' => ['image'],
                                    'previewFileType' => 'any',
                                    'showUpload' => false,
                                    'resizeImages' => true,
                                    'showRemove' => true,
                                    'initialPreview'=> !empty($model->image) ? $model->image : '',
                                    'initialPreviewAsData'=>true,
                                    'deleteUrl' => Url::to(['plan/delete-file', 'id' => $model->id, 'attribute' => 'image']),
                            ],
                        ])->label(false);  ?>
                </div>

                <label for='' class='col-sm-2 control-label'>السعر الشهري</label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'price')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='price_yearly' class='col-sm-2 control-label'>السعر السنوي</label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'price_yearly')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Plan Period')?></label>
                <div class='col-sm-4'>
                    <?php $model->isNewRecord ? $model->period=1:$model->period;?>
                    <?= $form->field($model, 'period')->radioList(Yii::$app->params['period'][Yii::$app->language])->label(false) ?>
                </div>


                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Currency')?></label>
                <div class='col-sm-4'>
                    <?php $model->isNewRecord ? $model->currency=1:$model->currency;?>
                    <?= $form->field($model, 'currency')->radioList(Yii::$app->params['currency'][Yii::$app->language])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 
                <div class='col-sm-4'>
                    <?php $model->isNewRecord ? $model->status=1:$model->status;?>
                    <?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sort At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'sort_at')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Plan Features')?></label>
                <div class='col-sm-10'>
                    <?=Yii::$app->view->renderFile('@backend/views/plan-item/_plan_items_widget.php',['models'=>$modelsPlanItem,'form'=>$form]);?>
                </div>

                <div class='clearfix'></div>
                <label for='contracts_count' class='col-sm-2 control-label'>عدد العقود</label>

                <div class='col-sm-10'>
                    <?= $form->field($model, 'contracts_count')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>
                <label for='sms_count' class='col-sm-2 control-label'>عدد الرسائل</label>

                <div class='col-sm-10'>
                    <?= $form->field($model, 'sms_count')->textInput(['maxlength' => true])->label(false) ?>
                </div>
			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
