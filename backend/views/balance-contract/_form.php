<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\EstateOffice;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\BalanceContract */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balance-contract-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Estate Office') ?> </label> 

				<div class='col-sm-6'>
					<?= $form->field($model, 'estate_office_id')->widget(Select2::class, ['data' =>ArrayHelper::map(EstateOffice::find()->where(['>','id',0])->all(),'id','name'),'options' => ['prompt'=>Yii::t('app','Select Estate Office')]])->label(false)?>
				</div>
			</div>
				
            <div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Number').' '.Yii::t('app', 'Contracts') ?> </label> 

				<div class='col-sm-6'><?= $form->field($model, 'amount')->textInput()->label(false) ?></div>
            </div>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Price') ?> </label> 

				<div class='col-sm-6'><?= $form->field($model, 'price')->textInput()->label(false) ?></div>

				
            </div>
			<div class='col-sm-12'>
			    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expire Contracts Date') ?> </label> 
				<div class='col-sm-6'> 
					<?= DatePicker::widget([
						'model' => $model,
						'attribute' => 'expire_date',
						//'form' => $form,
						'options' => ['placeholder' => yii::t('app','Expire Date')],
						'type' => DatePicker::TYPE_COMPONENT_PREPEND,
						'value' => '23-Feb-1982',
						'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd'
						]
					]); ?>
			
			    </div>
            </div>
		   
		   <div class="space_v"></div>
		   <div class="clearfix"></div>
	    </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
