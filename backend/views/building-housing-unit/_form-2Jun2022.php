<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\housingUnitType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Building;
use yii\redactor\widgets\Redactor;
use kartik\date\DatePicker;
$EOS = yii::$app->SiteSetting->queryEOS();


/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-housing-unit-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>""]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
            <legend><?=Yii::t('app','Building Info')?> :</legend>
            <div class='col-sm-12'> 
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building') ?> </label> 
                <div class='col-sm-4'>
                    <?php if($model->isNewRecord){ ?>
                        <?= $form->field($model, 'building_id')->widget(Select2::class, ['data' =>ArrayHelper::map(Building::find()->CurrentUser()->all(), 'id', 'building_name'),'options' => ['prompt'=>Yii::t('app','Select Building')]])->label(false)?>
                    <?php }else{ ?>
                        <label class='label-data'><?= $model->building->building_name ?></label>
                    <?php } ?>
                </div>
            </div>
            <div class='col-sm-12'> 
                <div class='col-sm-3'><?= $form->field($model, "housing_unit_name")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= 
                    $form->field($model, 'building_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['building_types']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Building Type')]])->label(false)
                     ?></div>
                <div class='col-sm-3'><?= $form->field($model, "area")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "floors_no")->textInput() ?></div>
                <div class="clearfix"></div>        

                <div class='col-sm-3'><?= $form->field($model, "entrances")->textInput() ?></div>
                <div class='col-sm-3'><?= $form->field($model, "rooms")->textInput() ?></div>
                <div class='col-sm-3'><?= $form->field($model, "toilets")->textInput() ?></div>
                <div class='col-sm-3'><?= $form->field($model, "conditioner_num")->textInput() ?></div>
                <div class="clearfix"></div>        

                <div class='col-sm-3'><?= $form->field($model, "using_for")->radioList(Yii::$app->params['renterType'][Yii::$app->language]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "kitchen")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "has_parking")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "pool")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
                <div class="clearfix"></div>        
                
                <div class='col-sm-3'><?= $form->field($model, "lounge")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "electricity_meter_no")->textInput(['maxlength' => true]) ?></div>
              
                <div class='col-sm-3'><?= $form->field($model, "neighborhood_name")->textInput(['maxlength' => true]) ?></div>
              
                <div class='col-sm-3'><?= $form->field($model, "street_name")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "longitude")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "lattitude")->textInput(['maxlength' => true]) ?></div>
              
               
                
              
                <div class='col-sm-3'><?= $form->field($model, "space")->textInput(['maxlength' => true]) ?></div>
              
                
                <div class='col-sm-3'><?= $form->field($model, "number_of_rooms")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "room_type")->textInput(['maxlength' => true]) ?></div>              
                <div class='col-sm-3'><?= $form->field($model, "real_estate_interface")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "street_view")->textInput(['maxlength' => true]) ?></div>
               
              
                <label for='' class='col-sm-3 control-label'><?= Yii::t('app', 'Limits and Lengths of the Property') ?> </label>
				<div class='col-sm-3'><?= $form->field($model, 'limits_length_property')->textInput(['maxlength' => true])->label(false) ?></div>
               
                <label for='' class='col-sm-7 control-label'><?= Yii::t('app', 'Is there a mortgage or restriction that prevents or limits the disposal or use of the property?') ?> </label>
				<div class='col-sm-5'><?= $form->field($model, "limit_property")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
               
                <label for='' class='col-sm-7 control-label'><?= Yii::t('app', 'Rights and obligations over real estate not documented in the real estate document') ?> </label>
				<div class='col-sm-5'><?= $form->field($model, "document_rights")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?></div>
               
                
              
              
              
            </div>
        </fieldset> 
      
      
        <fieldset>
		    <legend><?=Yii::t('app','Ad Details')?> :</legend>
			<div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Description')?></label>
        		<div class='col-sm-10'><?= $form->field($model, 'ad_description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
        		</div>

				<div class="clearfix"></div>

			   
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Publication Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'ad_publish_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ],
				        
				    ])->label(false); ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expiration Date') ?> </label> 

				<div class='col-sm-4'>
					<?= $form->field($model, 'ad_expire_date')->widget(DatePicker::class,[
				        'type' => DatePicker::TYPE_INPUT,
				        'value' => '23-Feb-1982',
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ])->label(false); ?>
				</div>
				<div class="clearfix"></div>
			</div>
         
         
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Category') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_side')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Character') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_adjective')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser License Number") ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_license_number')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser Name") ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_name')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser's Email") ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_email')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Advertiser Mobile Number') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_mobile')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
            <div class='col-sm-12'>	
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', "Advertiser Registration Number") ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'advertiser_registration_number')->textInput(['maxlength' => true])->label(false) ?></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Authorization Number') ?> </label>
				<div class='col-sm-4'><?= $form->field($model, 'authorization_number')->textInput(['maxlength' => true])->label(false) ?></div>                             
			</div>
         
         
         
            <div class='col-sm-12'>	
              
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Ad Type') ?> </label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'ad_type')->radioList(Yii::$app->params['adtype'][Yii::$app->language])->label(false) ?>
				</div>
              
              
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Ad Sub Type') ?> </label> 

				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=1:$model->status;?>
					<?= $form->field($model, 'ad_subtype')->radioList(Yii::$app->params['adsubtype'][Yii::$app->language])->label(false) ?>
				</div>
				<div class="clearfix"></div>
			</div>
          
           
    </fieldset>	
      
      
      
      
      
        <fieldset>
            <legend><?=Yii::t('app','Other Details')?> :</legend>
            <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Furniture')?></label>
            <div class='col-sm-10'>
                <?= $form->field($model, 'furniture')->widget(Redactor::class, [
                'clientOptions' => [
                    'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                    'lang' => Yii::$app->language,
                    'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                ]
                ])->label(false)?>
            </div>

            <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Detail')?></label>
            <div class='col-sm-10'><?= $form->field($model, 'detail')->widget(Redactor::class, [
                'clientOptions' => [
                    'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                    'lang' => Yii::$app->language,
                    'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                ]
                ])->label(false)?>
            </div>
        </fieldset> 
        <?php $model->isNewRecord ? $model->status=0:$model->status;?>
        <?php /*
        <div class='col-sm-6'><?= $form->field($model, "status")->checkbox(Yii::$app->params['statusHousRent'][Yii::$app->language]) ?></div>
        */?>
        <fieldset>
            <legend><?=Yii::t('app','Rent And Sale for full Building')?> :</legend>
            <div class="col-sm-12">
                <div class='col-sm-2'><?= $form->field($model, "for_rent")->checkbox(['value'=>1]) ?></div>
                <div class='col-sm-2'><?= $form->field($model, "price")->textInput() ?></div>
                <div class='col-sm-2'></div>
                <div class='col-sm-2'><?= $form->field($model, "for_sale")->checkbox(['value'=>1]) ?></div>
                <div class='col-sm-2'><?= $form->field($model, "sale_price")->textInput() ?></div>
            </div>
        </fieldset> 
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
