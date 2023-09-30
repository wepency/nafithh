<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\City;
use common\models\District;
use common\models\Nationality;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\EstateOffice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estate-office-form box box-primary">
	<?=Yii::$app->view->renderFile('@backend/views/user/_checkExists.php',['userType'=>'estate_officer']);?>
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
       <fieldset>
	        
			<div class='col-sm-12'>
				<?php if ($model->isNewRecord){ ?>
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 
					<div class='col-sm-10'><?= $form->field($model, 'asOwnerEstate')->checkbox()->label(false) ?></div>
				<?php } ?>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Auth Person') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'auth_person')->textInput(['maxlength' => true])->label(false) ?></div>
				
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Registration Code') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'registration_code')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Registration Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'registration_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>	
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Username') ?> </label> 
				
				<?php 
				 if ($model->isNewRecord){
					$attrs = ['maxlength' => true];
				 }else
					$attrs = ['maxlength' => true,'disabled'=>true];
					
				?>

				<div class='col-sm-4'><?= $form->field($model, '_username')->textInput($attrs)->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Password') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, '_password')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class="clearfix"></div>

				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Mobile') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Phone') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Email') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?></div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Nationality')?></label>
		        <div class='col-sm-4'>
		        	<?= $form->field($model, '_nationality_id')->widget(Select2::class, ['data' =>ArrayHelper::map(Nationality::find()->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Nationality')]])->label(false)?>
		        </div>

				<div class="clearfix"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'City ID') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'city_id')->widget(Select2::class, ['data' =>ArrayHelper::map(City::find()->where(['status'=>1])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select City')]])->label(false)?>
				</div>

				<label for='' class='col-sm-2 control-label'>
					<?= Yii::t('app', 'District ID') ?>
				</label> 

				<div class='col-sm-4'>
					<?php
							echo $form->field($model, "district_id")->widget(DepDrop::class, [
									'data'=> ($model->isNewRecord && !isset($model->city_id) ? [$model->city_id=>''] : District::ListDistrictByCar($model->city_id)),
									// 'data'=> ($model->isNewRecord ? [$model->city_id=>''] : District::ListDistrictByCar($model->city_id)),
		                            'type'=> DepDrop::TYPE_SELECT2,
									
									//'select2Options'=>['pluginOptions'=>['multiple' => false]],
									/*'options'=>[
										'id'=>"product-brand_model_id",
										'class'=>'form-control'
									],*/
									'pluginOptions'=>[
										'depends'=>["estateoffice-city_id"],
										'initialize' => true,
										'placeholder'=>Yii::t('app', 'Select District'),
										'url'=>Url::to(['/dropdown/district']),
										'loadingText' => Yii::t('app', 'Loading district ...'),
									]
								])->label(false); ?> 
								
				</div>
				<div class="clearfix"></div>
				
	            <?=Yii::$app->view->renderFile('@backend/views/layouts/map.php',['model'=>$model,'form'=>$form]);?>

				<div class="clearfix"></div>
			</div>
	    </fieldset>
		<div class="space_v"></div>

		<fieldset>
			<div class='col-sm-12'>
				<?php if(!$model->isNewRecord){ ?>
					<div class="row">
	                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Default SMS Balance Type')?></label>
	                    <div class='col-sm-4'>
	                        <?= $form->field($model, 'sms_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language])->label(false) ?>
	                    </div>
	                    
	                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Default Contract Balance Type')?></label>
	                    <div class='col-sm-4'>
	                        <?= $form->field($model, 'contract_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language])->label(false) ?>
	                    </div>

	                </div>
            	<?php } ?>
				<div class="clearfix"></div>


            	<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sms Expire Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'sms_expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
						'disabled' => true,
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Contract Expire Date') ?> </label> 
				<div class='col-sm-4'>
					<?= $form->field($model, 'contract_expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
						'disabled' => true,
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>

				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sms Balance') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'sms_balance')->textInput(['disabled' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Contract Balance') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'contract_balance')->textInput(['disabled' => true])->label(false) ?>
				</div>
				<div class="clearfix"></div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Notification Method') ?> </label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->notification_method=0:$model->notification_method;?>
					<?= $form->field($model, 'notification_method')->radioList(Yii::$app->params['sendingStatus'][Yii::$app->language])->label(false) ?>
						
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Tax Num') ?> </label> 

				<div class='col-sm-4'><?= $form->field($model, 'tax_num')->textInput(['maxlength' => true])->label(false) ?></div>
				<div class="clearfix"></div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expire Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
						'disabled' => true,
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status Account') ?> </label> 

				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status_account=10:$model->status_account;?>
					<?= $form->field($model, 'status_account')->radioList(Yii::$app->params['statusAccount'][Yii::$app->language])->label(false) ?>
				</div>
            </div>
	    </fieldset>
		<div class="space_v"></div>

		<fieldset>
	        
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Description') ?> </label> 

				<div class='col-sm-10'><?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                        </div>

				
                
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Logo') ?> </label> 
				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'logo')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->logo) ? $model->logo : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id,'logo']),
							],
						])->label(false);  ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Header Report Image') ?> </label> 

				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'header_report_image')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->header_report_image) ? $model->header_report_image : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id]),
							],
						])->label(false);  ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Footer Report Image') ?> </label> 

				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'footer_report_image')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->footer_report_image) ? $model->footer_report_image : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id]),
							],
						])->label(false);  ?>
				</div>
				<?php /*
				<div class="col-md-offset-1 col-md-3  col-sm-4">
					<?php $model->isNewRecord ? $model->enable_installment_deposit_bank=0:$model->enable_installment_deposit_bank;?>
					<?= $form->field($model, 'enable_installment_deposit_bank')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
							
				</div>
				<div class="col-md-offset-1 col-md-3 col-sm-4">
					<?php $model->isNewRecord ? $model->enable_installment_cash=0:$model->enable_installment_cash;?>
					<?= $form->field($model, 'enable_installment_cash')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
							
				</div>
				<div class="col-md-offset-1 col-md-3 col-sm-4">
					<?php $model->isNewRecord ? $model->enable_installment_pay_card=0:$model->enable_installment_pay_card;?>
					<?= $form->field($model, 'enable_installment_pay_card')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
							
				</div>
				<div class="clearfix"></div>
				*/?>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 

				<div class='col-sm-10'>
					<?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
				</div>
            </div>
	    </fieldset>
    </div>
            

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
