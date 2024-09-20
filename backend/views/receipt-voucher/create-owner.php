<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\MaintenanceOffice;
use common\models\ReceiptVoucher;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucher */
/* @var $form yii\widgets\ActiveForm */
$list = [];
// print_r($estatOffice->listOwner()); die();

$this->title = Yii::t('app', 'Create Receipt Voucher');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receipt Vouchers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="receipt-voucher-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <?php foreach ($estatOffice->getListAvailablePaymentMethod() as $key => $value) { 
                    $list[$key] = Yii::$app->params['PayMethod'][Yii::$app->language][$key]; ?>
                <?php } ?>
                    
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Payment Method')?></label>
                <div class='col-sm-4'>
                    
                    <?= $form->field($model, 'payment_method')->radioList($list)->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Owner Name')?></label>
                <div class='col-sm-4'>
                    <label class="label-data"><?=$model->owner->name .' '. "(".$model->owner->id.")"?></label>
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Amount')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'amount')->textInput()->label(false) ?>
                </div>


                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Amount Text')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'amount_text')->textInput(['maxlength' => true])->label(false) ?>
                </div>


                <div class='clearfix'></div>


                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Pay Against')?></label>
                    <div class='col-sm-10'><?= $form->field($model, 'pay_against')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
                    </div>


                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Details')?></label>
                <div class='col-sm-10'><?= $form->field($model, 'details')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
                </div>
                
                
                <div class='clearfix'></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 

                <div class='col-sm-10'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                </div> 

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
