<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

$label = isset($label)? $label : Yii::t('app','Housing Unit');
/* @var $this yii\web\View */
/* @var $model common\models\ProductOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
        // 'action' => ['report'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

        <label for='' class='col-sm-1 control-label'><?=$label?></label>
        <div class='col-sm-3'>
            <?= $form->field($model, 'housing_ids')->widget(Select2::class, [
            'data' => ArrayHelper::map($housingList,'id','housing_unit_name'),
            'options' => ['placeholder' => Yii::t('app','Housing Unit'), 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 20
            ],
            ])->label(false);?>
        </div>
        <label for='' class='col-sm-1 control-label'><?=yii::t('app','Created Date');?></label>
        <div class='col-sm-5'>
        <?= $form->field($model, 'startDate')->widget(DatePicker::class,[
                        'attribute2' =>'endDate',
                    // 'value2' => '27-Feb-2020',
                    // 'options2' => ['placeholder' => yii::t('app','To Date')],
                        'attribute2' =>'endDate',
                        'type' => DatePicker::TYPE_RANGE,
                        'options' => ['placeholder' => yii::t('app','From Date')],
                        'options2' => ['placeholder' => yii::t('app','To Date')],
                        'value' => '01-Feb-2020',
                        'value2' => '27-Feb-2020',
                       'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ])->label(false); ?>
        </div>
        <div class="form-group col-sm-2">
            <?= Html::submitButton(Yii::t('app', 'Fillter'), ['class' => 'btn btn-primary']) ?>
        </div>


    <?php ActiveForm::end(); ?>

