<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\MaintenanceOffice;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintenance-invoice-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Date')?></label>
                <div class='col-sm-10'>
                    <?= $form->field($model, 'date_from')->widget(DatePicker::class,[
                        'attribute2' =>'date_to',
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

                <div class='clearfix'></div>
<?php /*
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Total Amount')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'total_amount')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Commission Percent')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'commission_percent')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Commission Amount')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'commission_amount')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Office Earnings')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'office_earnings')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'User Created ID')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'user_created_id')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Created At')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'created_at')->textInput()->label(false) ?>
                </div>

                 <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Payment Status')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'payment_status')->textInput()->label(false) ?>
                </div>
*/ ?>
                <div class='clearfix'></div>
                 <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Maintenance Office')?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'maintenanceOffice')->widget(Select2::class, [
                        'data' => ArrayHelper::map(MaintenanceOffice::find()->all(),'id','name'),
                        'options' => ['placeholder' => Yii::t('app','Maintenance Office'), 'multiple' => true],
                        'pluginOptions' => [
                            'tags' => true,
                            'tokenSeparators' => [',', ' '],
                            'maximumInputLength' => 10
                        ],
                        ])->label(false);?>
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
