<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContactUs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-us-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Name')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Email')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Mobile')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Msg')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'msg')->textarea(['rows' => 6])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Created At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'created_at')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Replay Msg')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'replay_msg')->textarea(['rows' => 6])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'User ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'user_id')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'status')->textInput()->label(false) ?>
                </div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
