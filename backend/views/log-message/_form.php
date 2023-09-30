<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\LogMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-message-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sender ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'sender_id')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sender Type')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'sender_type')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Notif Temp ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'notif_temp_id')->textInput()->label(false) ?>
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

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contact Mobile')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contact Email')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Message')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'message')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'status')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Created Date')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'created_date')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
