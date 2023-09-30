<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\City;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\VolDistrict */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vol-district-form box box-primary">

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
				
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','City')?></label>
				<div class='col-sm-4'>
					<?= $form->field($model, 'city_id')->widget(Select2::class, ['data' =>ArrayHelper::map(City::find()->where(['status'=>1])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select City')]])->label(false)?>
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
