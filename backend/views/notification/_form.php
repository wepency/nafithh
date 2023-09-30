<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Notification Type')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'notification_type')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Receiver ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'receiver_id')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Receiver Type')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'receiver_type')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Content')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'content')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Subject ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'subject_id')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Table Name')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'table_name')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Created At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'created_at')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Readed At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'readed_at')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status Read')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'status_read')->textInput()->label(false) ?>
                </div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
