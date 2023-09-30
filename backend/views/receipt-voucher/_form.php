<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\MaintenanceOffice;
use common\models\ReceiptVoucher;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;
use common\models\BuildingHousingUnit;
use common\models\Building;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucher */
/* @var $form yii\widgets\ActiveForm */
$list = [];
// print_r($estatOffice->listOwner()); die();
?>

<div class="receipt-voucher-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Recipient Type')?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'recipient_type')->widget(Select2::class, ['data' => ReceiptVoucher::getListRecipient(),
                        'options' => ['prompt'=>Yii::t('app','Recipient Type'),
                    'onchange'=>'
                        value = $(this).children("option:selected").val();
                        mainOff = $(".field-receiptvoucher-maintenance_office_id");
                        hous = $(".field-receiptvoucher-building_housing_unit_id");
                        building = $(".building_id");
                        owner = $(".field-receiptvoucher-owner_id");
                        switch(value) {case "owner":hideEv(mainOff);hideEv(hous);hideEv(building);showEv(owner);break;case "maintenance_officer":showEv(mainOff);showEv(hous);hideEv(owner);showEv(building);break;default:hideEv(mainOff);showEv(hous);showEv(building);hideEv(owner);}function hideEv(elem) {elem.parent().prev().hide();elem.parent().hide();}function showEv(elem) {elem.parent().prev().show();elem.parent().show();}']])->label(false)?>
                </div>

                <?php foreach ($estatOffice->getListAvailablePaymentMethod() as $key => $value) { 
                    $list[$key] = Yii::$app->params['PayMethod'][Yii::$app->language][$key]; ?>
                <?php } ?>
                    
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Payment Method')?></label>
                <div class='col-sm-4'>
                    
                    <?= $form->field($model, 'payment_method')->radioList($list)->label(false) ?>
                </div>
                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label d-none'><?=Yii::t('app', 'Owner')?></label>
                <div class='col-sm-4 d-none' >
                    <?= $form->field($model, 'owner_id')->widget(Select2::class, ['data' =>ArrayHelper::map($estatOffice->listOwner(),'id','name'),'options' => ['prompt'=>Yii::t('app','Select Owner')]])->label(false)?>
                </div>

                <label for='' class='col-sm-2 control-label d-none'><?=Yii::t('app', 'Maintenance Office')?></label>
                <div class='col-sm-4 d-none'>
                    <?= $form->field($model, 'maintenance_office_id')->widget(Select2::class, ['data' =>ArrayHelper::map(MaintenanceOffice::find()->all(),'id','name'),'options' => ['prompt'=>Yii::t('app','Select Maintenance Office')]])->label(false)
                     ?>
                </div>

                <div class='clearfix'></div>
                 <label for='' class='col-sm-2 control-label d-none'><?=Yii::t('app', 'Building')?></label>
                <div class='col-sm-4 d-none'>
                    <div class='form-group building_id'>
                        <?=Select2::widget([
                            'name' => 'building_id',
                            'id' => 'building_id',
                            'value' => $model->buildingHousingUnit->building->id?? '',
                            'pluginOptions'=>[
                                'allowClear' => true,
                            'options' => ['prompt'=>Yii::t('app','Select Building'),'style'=>'width:100%']

                            ],
                            'data' =>ArrayHelper::map(Building::find()->CurrentUser()->all(), 'id', 'building_name'),
                            'options' => ['prompt'=>Yii::t('app','Select Building'),'style'=>'width:100%']
                        ]); ?>
                    </div>
                </div>

                <label for='' class='col-sm-2 control-label d-none'><?= Yii::t('app', 'Housing Unit Name') ?></label> 
                <div class='col-sm-4 d-none'>
                    <?php
                    echo $form->field($model, "building_housing_unit_id")->widget(DepDrop::class, [
                        'data'=> isset($model->buildingHousingUnit->building->id) ? BuildingHousingUnit::ListHousingByBuilding($model->buildingHousingUnit->building->id) : ArrayHelper::map($estateHousing,'id','housing_unit_name'),
                        'type'=> DepDrop::TYPE_SELECT2,
                        'pluginOptions'=>[
                            'depends'=>["building_id"],
                            'initialize' => true,
                            'placeholder'=>Yii::t('app', 'Select Housing Unit'),
                            'url'=>Url::to(['/dropdown/housing']),
                            'loadingText' => Yii::t('app', 'Loading Housing Unit ...'),
                        ]
                    ])->label(false); ?> 
                                
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
