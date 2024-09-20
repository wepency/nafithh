<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\IdentityType;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Renter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="renter-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
			<div class='col-sm-12'>
				<?=Yii::$app->view->renderFile('@backend/views/user/_form-any-user.php',['arrImages2' => $arrImages2,'model'=>$model,'form'=>$form]);?>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Work Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($modelRenter, 'work_name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Work Address') ?> </label> 

				<div class='col-sm-4'><?= $form->field($modelRenter, 'work_address')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Work Phone') ?> </label> 

				<div class='col-sm-4'><?= $form->field($modelRenter, 'work_phone')->textInput(['maxlength' => true])->label(false) ?></div>
            </div>
	    </fieldset>
   </div>
    <?php if (!Yii::$app->request->isAjax){ ?>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>
