<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Chat;

/* @var $this yii\web\View */
/* @var $model common\models\MessageSms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-sms-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Message')?></label>
                <div class='col-sm-10'>
                <?= $form->field($model, 'message')->textarea(['rows' => 6])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'To Group') ?> </label> 
                <div class='col-sm-4'>
                        <?= $form->field($model, 'groups')->widget(Select2::class, [
                    'data' => Chat::listReceivers(),
                    'options' => ['placeholder' => Yii::t('app','To Group'), 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 4
                    ],
                    ])->label(false);?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Numbers Mobile')?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'modelNumber')->widget(Select2::class, [
                    'options' => ['placeholder' => Yii::t('app','Numbers Mobile'), 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 50
                    ],
                    ])->label(false);?>
                </div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Save and Send'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
