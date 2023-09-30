<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use common\models\City;
use common\models\District;
use common\models\BuildingType;
use common\models\EstateOffice;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Building */
/* @var $form yii\widgets\ActiveForm */
$EOS = yii::$app->SiteSetting->queryEOS();
?>

<style>
  input[type="checkbox"], input[type="radio"]
  {
     margin-top:0 !important;
  }
</style>



<div class="building-form box box-primary">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['class'=>""]]); ?>
    <div class="box-body table-responsive">
		<fieldset>
		    <legend><?=Yii::t('app','Building Info')?> :</legend>
			<div class='col-sm-12'>
				
                
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Instrument Number') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'><?= $form->field($model, 'instrument_number')->textInput(['maxlength' => true])->label(false) ?></div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'owner_id')->widget(Select2::class, ['data' =>ArrayHelper::map(EstateOffice::listOwner(),'id','name'),'options' => ['prompt'=>Yii::t('app','Select Owner')]])->label(false)?>
				</div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Name') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'><?= $form->field($model, 'building_name')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Type') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'>
					<?= 
					$form->field($model, 'building_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['building_types']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Building Type')]])->label(false)
					 ?>
				</div>
				<div class="clearfix"></div>
				
				
				 <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Construction Date') ?> <span class="clsReq">*</span></label> 

              
                <div class='col-sm-4'>
					<?= $form->field($model, 'building_age')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
                            'todayHighlight' => true,
				            'format' => 'yyyy-mm-dd'
				        ],
				        
				    ])->label(false); ?>
				</div>
              
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Floors') ?> <span class="clsReq">*</span></label> 

                <div class='col-sm-4'><?= $form->field($model, 'floors')->textInput()->label(false) ?></div>
                
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Housing Units') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'><?= $form->field($model, 'housing_units')->textInput()->label(false) ?></div>
				
				<label for='' style="display:none;" class='col-sm-2 control-label'><?= Yii::t('app', 'Number Of Parking') ?> </label> 

				<div class='col-sm-4' style="display:none;"><?= $form->field($model, 'has_parking')->textInput()->label(false) ?></div>
				
				<?php if(!$model->isNewRecord){ ?>
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Status') ?> </label> 
					<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->building_status='new':$model->building_status;?>
						<?= $form->field($model, 'building_status')->radioList(Yii::$app->params['buildingStatus'][Yii::$app->language])->label(false) ?>
					</div>
                <?php } ?>
                <div class="clearfix"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'annual income') ?> </label> 
				<div class='col-sm-4'><?= $form->field($model, 'annual_income')->textInput(['maxlength' => true])->label(false) ?></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Water Meter Number') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'water_meter_no')->textInput(['maxlength' => true])->label(false) ?></div>


                
              
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Space') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'space')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Number of Rooms') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'number_of_rooms')->textInput(['maxlength' => true])->label(false) ?></div>
                
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Room Type') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'room_type')->textInput(['maxlength' => true])->label(false) ?></div>
               
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Real Estate Interface') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'real_estate_interface')->textInput(['maxlength' => true])->label(false) ?></div>
               
                <div style="clear:both;"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Street Width') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'street_view')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Facilities') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'facilities')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Using For') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'>                  
                  <?= $form->field($model, "using_for")->radioList(Yii::$app->params['renterType'][Yii::$app->language])->label(false) ?>
                </div>
                
                
              
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Furnished') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, "furnished")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                <div style="clear:both;"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Kitchen') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, "kitchen")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
               
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Air Condition') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, "aircondition")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                              
                
              
                <div style="clear:both;"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Availability of Elevators') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, "availability_elevators")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Number of Elevators') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'no_elevators')->textInput(['maxlength' => true])->label(false) ?></div>
                <div style="clear:both;"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Availability of Parking') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, "availability_parking")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Number of Parking') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'number_parking')->textInput(['maxlength' => true])->label(false) ?></div>
                
              
              
                <label for='' class='col-sm-7 control-label'><?= Yii::t('app', 'Is there a mortgage or restriction that prevents or limits the disposal or use of the property?') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-2'><?= $form->field($model, "limit_property")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                <label for='' class='col-sm-1 control-label'><?= Yii::t('app', 'If Yes') ?></label>
                <div class='col-sm-2'><?= $form->field($model, 'limit_property_yes')->textInput(['maxlength' => true])->label(false) ?></div>
              
              
                <label for='' class='col-sm-7 control-label'><?= Yii::t('app', 'Rights and obligations over real estate not documented in the real estate document') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-2'><?= $form->field($model, "document_rights")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                <label for='' class='col-sm-1 control-label'><?= Yii::t('app', 'If Yes') ?></label>
                <div class='col-sm-2'><?= $form->field($model, 'document_rights_yes')->textInput(['maxlength' => true])->label(false) ?></div>
              
                
              
                <label for='' class='col-sm-7 control-label'><?= Yii::t('app', 'Information that may affect the property') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-2'><?= $form->field($model, "information_affects")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
                <label for='' class='col-sm-1 control-label'><?= Yii::t('app', 'If Yes') ?></label>
                <div class='col-sm-2'><?= $form->field($model, 'information_affects_yes')->textInput(['maxlength' => true])->label(false) ?></div>
               
              
                

              
              
			</div>
		</fieldset>
		
      
      
       <fieldset>
		    <legend><?=Yii::t('app','Ad Details')?> :</legend>
			<div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Ad Description')?> <span class="clsReq">*</span></label>
        		<div class='col-sm-10'><?= $form->field($model, 'ad_description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
        		</div>

				<div class="clearfix"></div>

			   
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Publication Date') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'ad_publish_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
                            'todayHighlight' => true,
				            'format' => 'yyyy-mm-dd'
				        ],
				        
				    ])->label(false); ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expiration Date') ?> <span class="clsReq">*</span></label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'ad_expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
                            'todayHighlight' => true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>
				<div class="clearfix"></div>
			</div>
         
         
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Category') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'>
                  <?= $form->field($model, "advertiser_side")->radioList(Yii::$app->params['advertisertype'][Yii::$app->language])->label(false) ?>
                </div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Character') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'>
                  <?= $form->field($model, "advertiser_adjective")->radioList(Yii::$app->params['advertisercategory'][Yii::$app->language])->label(false) ?>                   
                </div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser License Number") ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_license_number')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser Name") ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_name')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser's Email") ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_email')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Mobile Number') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_mobile')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser Registration Number") ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_registration_number')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Authorization Number') ?> <span class="clsReq clsAuthNo" style="display:none;">*</span></label></label>
				<div class='col-sm-4'><?= $form->field($model, 'authorization_number')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
         
         
            <div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Ad Type') ?> <span class="clsReq">*</span></label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'ad_type')->radioList(Yii::$app->params['adtype'][Yii::$app->language])->label(false) ?>
				</div>
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Ad Sub Type') ?> <span class="clsReq">*</span></label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'ad_subtype')->radioList(Yii::$app->params['adsubtype'][Yii::$app->language])->label(false) ?>
				</div>
				<div class="clearfix"></div>
			</div>
         
         
            <div class='col-sm-12'>	
				
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> <span class="clsReq">*</span></label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'ad_status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
				</div>
				<div class="clearfix"></div>
			</div>
         
    </fieldset>	
      
      
           
		<fieldset>
		    <legend><?=Yii::t('app','Building Location')?> :</legend>
			<div class='col-sm-12'>
		        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'City') ?> <span class="clsReq">*</span></label> 
				<div class='col-sm-4'>
					<?= $form->field($model, 'city_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['citys']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select City')]])->label(false)?>
				</div>

				<label for='' class='col-sm-2 control-label'>
					<?= Yii::t('app', 'District') ?> <span class="clsReq">*</span>
				</label> 

				<div class='col-sm-4'>
					<?php
					echo $form->field($model, "district_id")->widget(DepDrop::class, [
					
						'data'=> ($model->isNewRecord && !isset($model->city_id) ? [$model->city_id=>''] : District::ListDistrictByCar($model->city_id)),
						'type'=> DepDrop::TYPE_SELECT2,
						
						'pluginOptions'=>[
							'depends'=>["building-city_id"],
							'initialize' => true,
							'placeholder'=>Yii::t('app', 'Select District'),
							'url'=>Url::to(['/dropdown/district']),
							'loadingText' => Yii::t('app', 'Loading district ...'),
						]
						])->label(false); ?> 
								
				</div>
		        <div class="clearfix"></div>
              
               
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Neighborhood Name') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'neighborhood_name')->textInput(['maxlength' => true])->label(false) ?></div>


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Street Name') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'street_name')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-12 control-label' style="font-weight:bold !important;" ><?= Yii::t('app', 'Limits and Lengths of the Property') ?> </label>
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'East') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'east')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'West') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'west')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'North') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'north')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'South') ?> <span class="clsReq">*</span></label>
				<div class='col-sm-4'><?= $form->field($model, 'south')->textInput(['maxlength' => true])->label(false) ?></div>

                
                <label for='' class='col-sm-2 control-label' style="display:none;"><?= Yii::t('app', 'Limits and Lengths of the Property') ?> <span class="clsReq">*</span></label>
				<div style="display:none;" class='col-sm-4'><?= $form->field($model, 'limits_length_property')->textInput(['maxlength' => true])->label(false) ?></div>
               
              
			   <div class="clearfix"></div>	
	            <?=Yii::$app->view->renderFile('@backend/views/layouts/map.php',['model'=>$model,'form'=>$form]);?>

				<div class="clearfix"></div>
            </div>
        </fieldset>
       <fieldset>
		    <legend><?=Yii::t('app','Other Details')?> :</legend>
			<div class='col-sm-12'>	
				<label for='' class='col-sm-1 control-label'><?=Yii::t('app', 'Description')?></label>
        		<div class='col-sm-10'><?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
        		</div>

				<div class="clearfix"></div>

			   
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Receive Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'receive_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
                            'todayHighlight' => true,
				            'format' => 'yyyy-mm-dd'
				        ],
				        
				    ])->label(false); ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expire Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
                            'todayHighlight' => true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>
				<div class="clearfix"></div>
			</div>
    </fieldset>	
	<fieldset>
		    <legend><?=Yii::t('app','Rent And Sale for full Building')?> :</legend>
			<div class='col-sm-12'>	
				
               <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Offer Type') ?> <span class="clsReq">*</span></label>
               <div class='col-sm-4'><?= $form->field($model, "offertype")->radioList(Yii::$app->params['offertype'][Yii::$app->language])->label(false) ?></div>
               
			   <label for='' style="width:120px;" class='col-sm-1 control-label'><?= Yii::t('app', 'Price') ?> <span class="clsReq">*</span></label> 
               <div class='col-sm-2'><?= $form->field($model, 'offerprice')->textInput()->label(false) ?></div>	
              
              
				<div class="clearfix"></div>		
				
            </div>
		</fieldset>
				
		<fieldset>
		    <legend><?=Yii::t('app','Attachments')?> :</legend>
			<div class='col-sm-12'>	
				
				<div class="clearfix"></div>
				<!--<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> -->

				<div class='col-sm-12'>
					<?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
				</div>
				
				<div class="clearfix"></div>
			</div>
        </fieldset>	
		<fieldset style="display:none;">
		    <div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 

				<div class='col-sm-10'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
				</div>
				<div class="clearfix"></div>
			</div>
        </fieldset>	
  
   
        
  
  
	    <div class="space_v"></div>
        <div class='col-sm-12'>
            <?= \common\components\HousingUnitWidget::widget(['model'=>$modelsHousings,'form'=>$form])?>
        </div>
		
    </div>

    


    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
 if(yii::$app->user->identity->user_type == 'owner'){
$script = <<< JS
    var ns = 'input,textarea,select';
    $(document).ready(function(){
        $( ns ).each( function( index, element ){
        	$(this).prop('readonly', true);
        });
        $( 'select').each( function( index, element ){
        	$(this).prop('disabled', true);
        });
        $("textarea[id='building-description']").redactor('core.destroy')
       $('input[id="building-imagefiles"]').fileinput('disable');

       $('input[name*="[for_rent]"]').prop('readonly', false);
       $('input[name*="[for_sale]"]').prop('readonly', false);
       $('input[name*="[rent_price]"]').prop('readonly', false);
       $('input[name*="[rent_price]"]').prop('readonly', false);
       $('input[name*="[sale_price]"]').prop('readonly', false);
       
       $("#building-advertiser_license_number").keypress(function() {
           value = $("#building-advertiser_license_number").val();
           alert(value);
       });

    });
JS;
$this->registerJs($script);
}


$scripts = <<< JS
  
    $(document).ready(function(){
        
       $("#building-advertiser_license_number").keyup(function() {
           value = $("#building-advertiser_license_number").val();
           
       });

    });
JS;
$this->registerJs($scripts);

?>
