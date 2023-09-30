<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
$setting = yii::$app->SiteSetting->info();
use yii\redactor\widgets\Redactor;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Nationality;
/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

    <div class="box-body table-responsive">
       
		<?php $this->beginBlock('website-info'); ?>
		<div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Website Info')?> :</legend>
			<div class='col-sm-12'>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Slug')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Slug En')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'slug_en')->textInput(['maxlength' => true])->label(false) ?>
	                </div>

	                <div class='clearfix'></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Site Name')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'site_name')->textInput(['maxlength' => true])->label(false) ?>
					</div>
					
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Site Name En')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'site_name_en')->textInput(['maxlength' => true])->label(false) ?>
					</div>
					
					 <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Email Admin')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'email_admin')->textInput(['maxlength' => true])->label(false) ?>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Contact Email')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'contact_email')->textInput(['maxlength' => true])->label(false) ?>
					</div>
					
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Key Words')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'key_words')->textInput(['maxlength' => true])->label(false) ?>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Key Google Map')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'key_google_map')->textInput(['maxlength' => true])->label(false) ?>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Copyright')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'copyright')->textInput(['maxlength' => true])->label(false) ?>
					</div>
					
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Copyright En')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'copyright_en')->textInput(['maxlength' => true])->label(false) ?>
					</div>
					
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Description')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
					</div>
				  
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Description En')?></label>
					<div class='col-sm-4'>
					<?= $form->field($model, 'description_en')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Tax Number')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'tax_number')->textInput(['maxlength' => true])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Account Number')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'account_number')->textInput(['maxlength' => true])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Iban Number')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'iban_number')->textInput(['maxlength' => true])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Bank Name')?></label>
	                <div class='col-sm-4'>
	                <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true])->label(false) ?>
	                </div>



				
			</div>
	    </fieldset>
	    <?php $this->endBlock(); ?>

	    <?php $this->beginBlock('social'); ?>
		<div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Social Media Links')?> :</legend>
			<div class='col-sm-12'>
			
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Facebook')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'facebook')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Twitter')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'twitter')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Youtube')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'youtube')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Linkedin')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'linkedin')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Instagram')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'instagram')->textInput(['maxlength' => true])->label(false) ?>
				</div>
	 		 </div>
	    </fieldset>
	    <?php $this->endBlock(); ?>

	    <?php $this->beginBlock('global_setting'); ?>
	    <div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Global Setting')?> :</legend>
			<div class='col-sm-12'>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Tax Percent Maintenance Order')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'tax_percent_maintenance_order')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Added Tax')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'added_tax')->textInput()->label(false) ?>
                </div>

                <div class='clearfix'></div>
                <div class="col-sm-12 col-md-6">
                	<label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default Contract Balance Type')?></label>
	                <div class='col-sm-4 col-md-8'>
	                	<?= $form->field($model, 'contract_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default Contract Balance')?></label>
	                <div class='col-sm-4 col-md-8'>
	                <?= $form->field($model, 'contract_default_no')->textInput()->label(false) ?>
	                </div>

	                <div class='clearfix'></div>

	                <label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default Contract Balance Period')?></label>
	                <div class='col-sm-4 col-md-8'>
	                <?= $form->field($model, 'contract_default_period')->textInput()->label(false) ?>
	                </div>
	                <label for='' class='col-sm-2 col-md-4 control-label'><?= Yii::t('app', 'Default Nationalty when Signup') ?> </label> 
			        <div class='col-sm-4 col-md-8'>
			            <?= $form->field($model, 'default_nationality_id')->widget(Select2::class, ['data' =>ArrayHelper::map(Nationality::find()->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Nationality')]])->label(false)?>
			        </div>
	            </div>
	            <div class="col-sm-12 col-md-6">
                	<label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default SMS Balance Type')?></label>
	                <div class='col-sm-4 col-md-8'>
	                	<?= $form->field($model, 'sms_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language])->label(false) ?>
	                </div>

	                <label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default SMS Balance')?></label>
	                <div class='col-sm-4 col-md-8'>
	                <?= $form->field($model, 'sms_default_no')->textInput()->label(false) ?>
	                </div>

	                <div class='clearfix'></div>

	                <label for='' class='col-sm-2 col-md-4 control-label'><?=Yii::t('app', 'Default SMS Balance Period')?></label>
	                <div class='col-sm-4 col-md-8'>
	                <?= $form->field($model, 'sms_default_period')->textInput()->label(false) ?>
	                </div>

	                
	                <div class='clearfix'></div>

	            </div>

                <?php /*
                <div class='clearfix'></div>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract Maintenance Free No')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'contract_maintenance_free_no')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract Maintenance Free Period')?></label>
                <div class='col-sm-4'>
                <?= $form->field($model, 'contract_maintenance_free_period')->textInput()->label(false) ?>
                </div>
				*/ ?>
                <div class='clearfix'></div>
                <div class="row">
                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'payment Method') ?> </label> 
	                <div class="col-sm-2">
	                    <?= $form->field($model, 'enable_installment_deposit_bank')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
	                            
	                </div>
	                <div class="col-sm-2">
	                    <?= $form->field($model, 'enable_installment_cash')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
	                            
	                </div>
	                <div class="col-sm-2">
	                    <?= $form->field($model, 'enable_installment_pay_card')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
	                            
	                </div>
	                <div class="col-sm-2">
	                    <?= $form->field($model, 'enable_installment_network')->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
	                            
	                </div>
                </div>
                <div class='clearfix'></div>
	 		 </div>
	    </fieldset>
	    <?php $this->endBlock(); ?>
			
	    <?php $this->beginBlock('content'); ?>
		<div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Texts In Pages')?> :</legend>
			<div class='col-sm-12'>
			
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Text In Services Page')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'services_text')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Text In Services Page En')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'services_text_en')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Text In partners Page')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'partners_text')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Text In partners Page En')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'partners_text_en')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Terms And Conditions')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'terms_and_conditions')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>'rtl',
                            'lang' => 'ar',
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Terms And Conditions En')?></label>
				<div class='col-sm-10'>
					<?= $form->field($model, 'terms_and_conditions_en')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>'ltr',
                            'lang' => 'en',
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>
				
				<?= $form->field($model, 'admin_theme')->textInput(['maxlength' => true,'class'=>'hidden'])->label(false) ?>

			</div>
	    </fieldset> 
	    <?php $this->endBlock(); ?>

	    <?php $this->beginBlock('image'); ?>
     	<div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Logos & images')?> :</legend>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Logo')?></label>
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
									'deleteUrl' => Url::to(['setting/delete-file', 'id' => $model->id, 'attribute' => 'logo']),
							],
						])->label(false);  ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Icon')?></label>
				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'icon')->widget(FileInput::class, [
							'options' => ['accept' => 'ico/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->icon) ? $model->icon : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['setting/delete-file', 'id' => $model->id, 'attribute' => 'icon']),
							],
						])->label(false);  ?>
				</div>
				 <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Image In About Page')?></label>
				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'about_image')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->about_image) ? $model->about_image : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['setting/delete-file', 'id' => $model->id, 'attribute' => 'about_image']),
							],
						])->label(false);  ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Profile')?></label>
				<div class='col-sm-10'>
				<?=$form->field($model, 'profile')->widget(FileInput::class, [
					'options' => ['accept' => 'application/pdf'],
					'pluginOptions' => [
						'allowedFileExtensions' => ['pdf'],
						'previewFileType' => 'pdf',
						'showUpload' => false,
						'showRemove' => true,
						'initialPreviewAsData'=>true,
						'initialPreview'=> !empty($model->profile) ? [$model->profile] : '',
						'initialPreviewConfig' => array(/*'caption' => $model->name, 'size' => 150,*/ 'type' => 'pdf', 'filetype' => 'application/pdf',
						'url' => Url::to(['setting/delete-file', 'id' => $model->id, 'attribute' => 'profile']))
					],
				])->label(false);  ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Profile En')?></label>
				<div class='col-sm-10'>
				<?=$form->field($model, 'profile_en')->widget(FileInput::class, [
					'options' => ['accept' => 'application/pdf'],
					'pluginOptions' => [
						'allowedFileExtensions' => ['pdf'],
						'previewFileType' => 'pdf',
						'showUpload' => false,
						'showRemove' => true,
						'initialPreviewAsData'=>true,
						'initialPreview'=> !empty($model->profile_en) ? [$model->profile_en] : '',
						'initialPreviewConfig' => array(/*'caption' => $model->name, 'size' => 150,*/ 'type' => 'pdf', 'filetype' => 'application/pdf',
						'url' => Url::to(['setting/delete-file', 'id' => $model->id, 'attribute' => 'profile_en']))
					],
				])->label(false);  ?>
				</div>

			</div>
	    </fieldset> 
		<?php $this->endBlock(); ?>

		<?php $this->beginBlock('contact'); ?>
		<fieldset>
		    <legend><?=Yii::t('app','Contact Info')?> :</legend>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Address')?></label>
				<div class='col-sm-10'>
				<?= $form->field($model, 'address')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Address En')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'address_en')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Mobile')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Phone')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Email')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
				</div>
            </div>
	    </fieldset> 
		<div class="space_v"></div>
		<fieldset>
		    <legend><?=Yii::t('app','Google Map')?> :</legend>
			<div class='col-sm-12'>
				<div class="clearfix"></div>
                    <?=Yii::$app->view->renderFile('@backend/views/layouts/map.php',['model'=>$model,'form'=>$form]);?>
                <div class="clearfix"></div>
			</div>
         </fieldset> 
		<?php $this->endBlock(); ?>


		<?php $this->beginBlock('theme'); ?>
		<fieldset>
		   
			<div class="col-sm-12" >
			<div class="col-sm-12 box box-solid" >
			  <div class="box-body no-padding">
				<table id="layout-skins-list" class="table table-striped bring-up nth-2-center">
				  <thead>
					<tr>
					  <th style="width: 210px;">Skin Class</th>
					  <th>Preview</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  <td><code>skin-blue</code></td>
					  <td><a href="#" data-skin="skin-blue" style="background-color: #3c8dbc!important;" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-blue-light</code></td>
					  <td><a href="#" data-skin="skin-blue-light" style="background-color: #3c8dbc!important;" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-yellow</code></td>
					  <td><a href="#" data-skin="skin-yellow" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-yellow-light</code></td>
					  <td><a href="#" data-skin="skin-yellow-light" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-green</code></td>
					  <td><a href="#" data-skin="skin-green" style="background-color: #398439!important;" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-green-light</code></td>
					  <td><a href="#" data-skin="skin-green-light" style="background-color: #398439!important;" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-purple</code></td>
					  <td><a href="#" data-skin="skin-purple" class="btn bg-purple btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-purple-light</code></td>
					  <td><a href="#" data-skin="skin-purple-light" class="btn bg-purple btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-red</code></td>
					  <td><a href="#" data-skin="skin-red" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-red-light</code></td>
					  <td><a href="#" data-skin="skin-red-light" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-black</code></td>
					  <td><a href="#" data-skin="skin-black" class="btn bg-black btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
					<tr>
					  <td><code>skin-black-light</code></td>
					  <td><a href="#" data-skin="skin-black-light" class="btn bg-black btn-xs"><i class="fa fa-eye"></i></a></td>
					</tr>
				  </tbody>
				</table>
			  </div><!-- /.box-body -->
			</div>
		</div>
		</fieldset>
		<?php $this->endBlock(); ?>
			
		<?php echo Tabs::Widget([
			'tabContentOptions' => [
				'class'=>'pad',
			],
			'items' => [
				[
					'label' => yii::t('app','Website Info'),
					'content' => $this->blocks['website-info'],
					'active' => true,
				],
				 [
					'label' => yii::t('app','Social Media Links'),
					'content' => $this->blocks['social'],
				],
				[
					'label' => yii::t('app','Global Setting'),
					'content' => $this->blocks['global_setting'],
				], 
				[
					'label' => yii::t('app','Texts In Pages'),
					'content' => $this->blocks['content'],
				], 
				[
					'label' => yii::t('app','Logos & images'),
					'content' => $this->blocks['image'],
				], 
				[
					'label' => yii::t('app','Contact Info'),
					'content' => $this->blocks['contact'],
				],
				[
					'label' => yii::t('app','Admin Theme'),
					'content' => $this->blocks['theme'],
				],
			]
		]); ?>
    </div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    
</div>

<?php 

$script = <<< JS

    var currentSkin = '$model->admin_theme';

    $('#layout-skins-list [data-skin]').click(function (e) {
        e.preventDefault()
        var skinName = $(this).data('skin')
        $('body').removeClass(currentSkin)
        $('body').addClass(skinName)
        currentSkin = skinName
        $('#setting-admin_theme').val(skinName)
    });

$('#w0').on('afterValidate', function(event, messages, errorAttributes){
    // consloe.log("ddd");
  if(errorAttributes.length > 0) {
    var errElement = $('#' + errorAttributes[0].id);
    var pane = errElement.closest('[class="tab-pane"]');
    var tabId = pane[0].id;
    $('.nav-tabs a[href="#' + tabId + '"]').tab('show');
    return false;
  }
});
    
$("html").on("keypress", function (e){
    if (e.which == 13 ){
        e.preventDefault();
    }
});


JS;
$this->registerJs($script);

?>
