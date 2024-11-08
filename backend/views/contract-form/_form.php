<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
/* @var $this yii\web\View */
/* @var $model common\models\ContractForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contract-form-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name En') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Body') ?> </label> 
				<div class='col-sm-10'><?= $form->field($model, 'body')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                        	
                        </div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Body En') ?> </label> 

				<div class='col-sm-10'><?= $form->field($model, 'body_en')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                </div>

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
