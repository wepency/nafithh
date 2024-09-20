<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\SystemIncome */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-income-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Income Item')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'item')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Amount')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'amount')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Income Date')?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'pay_date')->widget(DatePicker::class,[
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => '23-Feb-2021',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ])->label(false); ?>
                </div>
                <div class='clearfix'></div>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Details')?></label>
                <div class='col-sm-10'><?= $form->field($model, 'details')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>'rtl',
                            'lang' => 'ar',
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
                </div>


                

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
