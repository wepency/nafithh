<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\Installment */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="installment-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">

		<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract No')?></label>
        <div class='col-sm-4'>
            <label class='label-data'><?= $model->contract->contract_no; ?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Payment Status')?></label>
        <div class='col-sm-4'>
            <label class='label-data'><?= Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status]; ?></label>
        </div>

        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Amount')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'amount')->textInput()->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'amount in letters')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'amount_text')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="clearfix"></div>

        <?php /*<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Received amount')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'amount_paid')->textInput()->label(false) ?>
        </div>
        
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Remaining amount')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'amount_remaining')->textInput()->label(false) ?>
        </div>
        */ ?>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Other Details')?></label>
        <div class='col-sm-10'><?= $form->field($model, 'details')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
        </div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Installment Start Date')?></label>
        <div class='col-sm-4'>
            <?= $form->field($model, 'start_date')->widget(DatePicker::class,[
                'type' => DatePicker::TYPE_INPUT,
                'value' => '23-Feb-1982',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label(false); ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Installment End Date')?></label>
        <div class='col-sm-4'>
            <?= $form->field($model, 'end_date')->widget(DatePicker::class,[
                'type' => DatePicker::TYPE_INPUT,
                'value' => '23-Feb-1982',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label(false);?>
            
        </div>

        <div class="clearfix"></div>

	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
