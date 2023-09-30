<?php

// use wbraganca\dynamicform\DynamicFormWidget;

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\redactor\widgets\Redactor;


// use yii\helpers\Url;
// use yii\web\JsExpression;
// use common\models\housingUnitType;
// use kartik\select2\Select2;
// use yii\helpers\ArrayHelper;
// $EOS = yii::$app->SiteSetting->queryEOS();


?>
<div class="installment-form box box-primary">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['class'=>""]]); ?>
     <div class="box-body table-responsive">
        <?php foreach ($models as $i => $model): ?>
            <fieldset>
                <legend><?=Yii::t('app','Installment'). ': '. $i ?></legend>
				<div class='col-sm-12'>
                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract No')?></label>
                    <div class='col-sm-4'>
                        <label class='label-data'><?= $contract_id; ?></label>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Amount')?></label>
                    <div class='col-sm-4'>
                    <?= $form->field($model, "[{$i}]amount")->textInput()->label(false) ?>
                    </div>

                    <div class="clearfix"></div>


                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Other Details')?></label>
                    <div class='col-sm-10'><?= $form->field($model, "[{$i}]details")->widget(Redactor::class, [
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
                        <?= $form->field($model, "[{$i}]start_date")->widget(DatePicker::class,[
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
                        <?= $form->field($model, "[{$i}]end_date")->widget(DatePicker::class,[
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '23-Feb-1982',
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false);?>
                        
                    </div>
                </div>
            </fieldset>
        <?php endforeach; ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        