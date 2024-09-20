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
            <legend><?=Yii::t('app','Unit Info')?> :</legend>
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
                    $form->field($model, 'building_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['building_types']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Building Type')]])
                     ?>
                </div>
                <div class='col-sm-3'><?= $form->field($model, "space")->textInput(['maxlength' => true]) ?></div>
                <div class='col-sm-3'><?= $form->field($model, "floors_no")->textInput() ?></div>
                <div class="clearfix"></div>        

                <div class='col-sm-3'><?= $form->field($model, "entrances")->textInput() ?></div>
                <div class='col-sm-3'><?= $form->field($model, "rooms")->textInput() ?></div>
<!--                <div class='col-sm-3'>--><?php //= $form->field($model, "room_type")->textInput() ?><!--</div>-->
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
                <div class='col-sm-3'><?= $form->field($model, "water_meter_no")->textInput(['maxlength' => true]) ?></div>
                <div class="clearfix"></div>

<!--                 <label for='' class='col-sm-12 control-label' style="font-weight:bold !important;" >--><?php //= Yii::t('app', 'Limits and Lengths of the Property') ?><!-- </label>-->
<!--                <div class='col-sm-3'>--><?php //= $form->field($model, "length")->textInput(['maxlength' => true]) ?><!--</div>-->
<!--                <div class='col-sm-3'>--><?php //= $form->field($model, "width")->textInput(['maxlength' => true]) ?><!--</div>-->
<!--                <div class="clearfix"></div> -->
                
<!--                <label for='' class='col-sm-2 control-label'>--><?php //=Yii::t('app', 'Title Ads')?><!-- <span class="clsReq">*</span></label>-->
<!--                <div class='col-sm-4'>-->
<!--                    --><?php //= $form->field($model, 'ad_description')->textInput(['placeholder'=>Yii::t('app', 'Example: a two-story apartment in Al-Falah neighborhood')])->label(false) ?>
<!--                </div> -->
<!--                <div class="clearfix"></div> -->

<!--                <label for='' class='col-sm-2 control-label'>--><?php //= Yii::t('app', 'Publication Date') ?><!-- <span class="clsReq">*</span></label> -->
<!--                <div class='col-sm-4'>-->
<!--                    --><?php //= $form->field($model, 'ad_publish_date')->widget(DatePicker::class,[
//                        'type' => DatePicker::TYPE_INPUT,
//                        'value' => '23-Feb-1982',
//                        'pluginOptions' => [
//                            'autoclose'=>true,
//                            'todayHighlight' => true,
//                            'format' => 'yyyy-mm-dd'
//                        ],
//
//                    ])->label(false); ?>
<!--                </div>-->
<!--                <label for='' class='col-sm-2 control-label'>--><?php //= Yii::t('app', 'Expiration Date') ?><!-- <span class="clsReq">*</span></label> -->
<!--                <div class='col-sm-4'>-->
<!--                    --><?php //= $form->field($model, 'ad_expire_date')->widget(DatePicker::class,[
//                        'type' => DatePicker::TYPE_INPUT,
//                        'value' => '23-Feb-1982',
//                        'pluginOptions' => [
//                            'autoclose'=>true,
//                            'todayHighlight' => true,
//                            'format' => 'yyyy-mm-dd'
//                        ]
//                    ])->label(false)->hint( Yii::t('app', 'On this date, the ad will be hidden from the gallery')); ?>
<!--                </div>-->
<!--                <div class="clearfix"></div>        -->
<!--                <label for='' class='col-sm-2 control-label'>--><?php //= Yii::t('app', 'Status Ad') ?><!-- <span class="clsReq">*</span></label> -->
<!--                <div class='col-sm-4'>-->
<!--                    --><?php //$model->isNewRecord ? $model->ad_status=1:$model->ad_status;?>
<!--                    --><?php //= $form->field($model, 'ad_status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
<!--                </div>-->
<!--                <label for='' class='col-sm-2 control-label'>--><?php //= Yii::t('app', 'Ad Sub Type') ?><!-- <span class="clsReq">*</span></label>-->
<!--                <div class='col-sm-4'>--><?php //= $form->field($model, "ad_subtype")->radioList(Yii::$app->params['adsubtype'][Yii::$app->language])->label(false) ?><!--</div>-->
                <div class="clearfix"></div> 

            </div>
        </fieldset> 
      
        <fieldset>
            <legend><?=Yii::t('app','Other Details')?> :</legend>
            <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Detail')?></label>
            <div class='col-sm-10'><?= $form->field($model, 'detail')->widget(Redactor::class, [
                'clientOptions' => [
                    'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                    'lang' => Yii::$app->language,
                    // 'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander'],
                    'buttons'=>false,
                    

                ]
                ])->label(false)?>
            </div>
        </fieldset> 
        <?php $model->isNewRecord ? $model->status=0:$model->status;?>
        <?php /*
        <div class='col-sm-6'><?= $form->field($model, "status")->checkbox(Yii::$app->params['statusHousRent'][Yii::$app->language]) ?></div>
        */?>
        <fieldset>
            <legend><?=Yii::t('app','Rent And Sale for full Unit')?> :</legend>
            <div class='col-sm-12'> 
               
                <div class='col-sm-12'> 
                    <div class='col-sm-3'><?= $form->field($model, 'for_rent')->checkbox(['value'=>1]) ?></div>
                    <div class='col-sm-3'><?= $form->field($model, 'for_sale')->checkbox(['value'=>1]) ?></div>
                    <div class='col-sm-3'><?= $form->field($model, 'for_invest')->checkbox(['value'=>1]) ?></div>
                    <div class="clearfix"></div>        
                </div>
                <div class="col-sm-12">
                    <div class='col-sm-3'><?= $form->field($model, "rent_price")->textInput(['maxlength' => true]) ?></div>
                    <div class='col-sm-3'><?= $form->field($model, "sale_price")->textInput(['maxlength' => true]) ?></div>
                    <div class='col-sm-3'><?= $form->field($model, "invest_price")->textInput(['maxlength' => true]) ?></div>
                    <div class="clearfix"></div> 
                </div>
            </div>
        </fieldset> 
        <fieldset>
            <legend><?=Yii::t('app','Housing Unit Images')?> :</legend>
            <div class='col-sm-12'> 
                
                <div class="clearfix"></div>
                <!--<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> -->

                <div class='col-sm-12'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                </div>
                
                <div class="clearfix"></div>
            </div>
        </fieldset> 
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
