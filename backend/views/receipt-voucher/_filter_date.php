<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

$label = isset($label) ? $label : Yii::t('app', 'Date');
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

    <div class="box-body table-responsive">
        <label for='' class='col-sm-2 control-label'><?= $label ?></label>
        <div class='col-sm-8'>
            <?= $form->field($model, 'created_date')->widget(DatePicker::class, [
//                'attribute2' => 'endDate',
//                // 'value2' => '27-Feb-2020',
//                // 'options2' => ['placeholder' => yii::t('app','To Date')],
                'attribute2' => 'created_date',
                'type' => DatePicker::TYPE_RANGE,
                'options' => ['placeholder' => yii::t('app', 'From Date')],
                'options2' => ['placeholder' => yii::t('app', 'To Date')],
                'value' => '01-Feb-2020',
                'value2' => '27-Feb-2020',
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label(false); ?>


            <?php // echo $form->field($model, 'price') ?>

            <?php // echo $form->field($model, 'total_price') ?>
        </div>
        <div class="form-group col-sm-2">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <!-- <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?> -->
        </div>
    </div>

<?php ActiveForm::end(); ?>