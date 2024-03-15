<?php

use common\models\District;
use common\models\EstateOffice;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Building */
/* @var $form yii\widgets\ActiveForm */
$EOS = yii::$app->SiteSetting->queryEOS();
?>

<style>
    input[type="checkbox"], input[type="radio"] {
        margin-top: 0 !important;
    }
</style>


<div class="building-form box box-primary">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => ""]]); ?>
    <div class="box-body table-responsive">
        <!--       <fieldset>-->
        <!--		    <legend>--><?php //=Yii::t('app','Ad Details')?><!-- :</legend>-->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Advertiser Category') ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <!--                  --><?php //= $form->field($model, "advertiser_side")->radioList(Yii::$app->params['advertisertype'][Yii::$app->language])->label(false) ?>
        <!--                </div>-->
        <!--                -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Advertiser Character') ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <!--                  -->
        <?php //= $form->field($model, "advertiser_adjective")->radioList(Yii::$app->params['advertisercategory'][Yii::$app->language])->label(false) ?><!--                   -->
        <!--                </div>                             -->
        <!--			</div>-->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', "Advertiser License Number") ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'advertiser_license_number')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
        <!--                -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', "Advertiser Name") ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'advertiser_name')->textInput(['maxlength' => true])->label(false) ?><!--</div>                             -->
        <!--			</div>-->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', "Advertiser's Email") ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'advertiser_email')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
        <!--                -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Advertiser Mobile Number') ?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'advertiser_mobile')->textInput(['maxlength' => true])->label(false) ?><!--</div>                             -->
        <!--			</div>-->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', "Advertiser Registration Number") ?><!-- </label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'advertiser_registration_number')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
        <!--                -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Authorization Number') ?><!-- <span class="clsReq">*</span></label></label>-->
        <!--				<div class='col-sm-4'>-->
        <?php //= $form->field($model, 'authorization_number')->textInput(['maxlength' => true])->label(false) ?><!--</div>                             -->
        <!--			</div>-->
        <!--         -->
        <!--         -->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--				<label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Ad Type') ?><!-- <span class="clsReq">*</span></label> -->
        <!--				<div class='col-sm-4'>-->
        <!--					--><?php //$model->isNewRecord ? $model->ad_type=1:$model->ad_type;?>
        <!--					--><?php //= $form->field($model, 'ad_type')->radioList(Yii::$app->params['adtype'][Yii::$app->language])->label(false) ?>
        <!--				</div>-->
        <!--              -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Ad Sub Type') ?><!-- <span class="clsReq">*</span></label> -->
        <!--				<div class='col-sm-4'>-->
        <!--					--><?php //$model->isNewRecord ? $model->ad_subtype=1:$model->ad_subtype;?>
        <!--					--><?php //= $form->field($model, 'ad_subtype')->radioList(Yii::$app->params['adsubtype'][Yii::$app->language])->label(false) ?>
        <!--				</div>-->
        <!--				<div class="clearfix"></div>-->
        <!--			</div>-->
        <!--         -->
        <!--		    <div class='col-sm-12'>	-->
        <!--				<label for='' class='col-sm-2 control-label'>-->
        <?php //=Yii::t('app', 'Title Ads')?><!-- <span class="clsReq">*</span></label>-->
        <!--				<div class='col-sm-10'>-->
        <!--	                --><?php //= $form->field($model, 'ad_description')->textInput(['placeholder'=>Yii::t('app', 'Example: A villa for sale in Al-Rabee neighborhood')])->label(false) ?>
        <!--				</div>-->
        <!---->
        <!--				<div class="clearfix"></div>-->
        <!---->
        <!--			   -->
        <!--				-->
        <!--				<label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Publication Date') ?><!-- <span class="clsReq">*</span></label> -->
        <!---->
        <!--				<div class='col-sm-4'>-->
        <!--					--><?php //= $form->field($model, 'ad_publish_date')->widget(DatePicker::class,[
        //				        'type' => DatePicker::TYPE_INPUT,
        //				        'value' => '23-Feb-1982',
        //				        'pluginOptions' => [
        //				            'autoclose'=>true,
        //                            'todayHighlight' => true,
        //				            'format' => 'yyyy-mm-dd'
        //				        ],
        //
        //				    ])->label(false); ?>
        <!--				</div>-->
        <!---->
        <!--				<label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Expiration Date') ?><!-- <span class="clsReq">*</span></label> -->
        <!---->
        <!--				<div class='col-sm-4'>-->
        <!--					--><?php //= $form->field($model, 'ad_expire_date')->widget(DatePicker::class,[
        //				        'type' => DatePicker::TYPE_INPUT,
        //				        'value' => '23-Feb-1982',
        //				        'pluginOptions' => [
        //				            'autoclose'=>true,
        //                            'todayHighlight' => true,
        //				            'format' => 'yyyy-mm-dd'
        //				        ]
        //				    ])->label(false)->hint( Yii::t('app', 'On this date, the ad will be hidden from the gallery')); ?>
        <!--				</div>-->
        <!--				<div class="clearfix"></div>-->
        <!--			</div>-->
        <!--         -->
        <!--            <div class='col-sm-12'>	-->
        <!--				-->
        <!--              -->
        <!--                <label for='' class='col-sm-2 control-label'>-->
        <?php //= Yii::t('app', 'Status Ad') ?><!-- <span class="clsReq">*</span></label> -->
        <!--				<div class='col-sm-4'>-->
        <!--					--><?php //$model->isNewRecord ? $model->ad_status=1:$model->ad_status;?>
        <!--					--><?php //= $form->field($model, 'ad_status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
        <!--				</div>-->
        <!--				<div class="clearfix"></div>-->
        <!--			</div>-->
        <!--         -->
        <!--    </fieldset>	-->

        <fieldset>
            <legend><?= Yii::t('app', 'Building Info') ?> :</legend>

            <div class='col-sm-12'>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Instrument Number') ?> </label>

                <div class='col-sm-4'><?= $form->field($model, 'instrument_number')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner') ?> <span class="clsReq">*</span></label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'owner_id')->widget(Select2::class, ['data' => ArrayHelper::map(EstateOffice::listOwner(), 'id', 'name'), 'options' => ['prompt' => Yii::t('app', 'Select Owner')]])->label(false) ?>
                </div>

                <div class="clearfix"></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Name') ?> <span class="clsReq">*</span></label>

                <div class='col-sm-4'><?= $form->field($model, 'building_name')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Type') ?> </label>

                <div class='col-sm-4'>
                    <?=
                    $form->field($model, 'building_type_id')->widget(Select2::class, ['data' => ArrayHelper::map($EOS['building_types']->where(['>', 'id', 0])->all(), 'id', '_name'), 'options' => ['prompt' => Yii::t('app', 'Select Building Type')]])->label(false)
                    ?>
                </div>

                <div class="clearfix"></div>


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Age') ?> </label>


                <div class='col-sm-4'>
                    <?= $form->field($model, 'building_age')->textInput(['type' => 'Number', 'maxlength' => true, 'placeholder' => Yii::t('app', 'set Value empty Or "0" If New')])->label(false)/*->hint(Yii::t('app', 'set Value empty Or "0" If New'))*/ ?>
                </div>


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Floors') ?></label>

                <div class='col-sm-4'><?= $form->field($model, 'floors')->textInput()->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Housing Units') ?></label>

                <div class='col-sm-4'><?= $form->field($model, 'housing_units')->textInput()->label(false) ?></div>

                <label for='' style="display:none;"
                       class='col-sm-2 control-label'><?= Yii::t('app', 'Number Of Parking') ?> </label>

                <div class='col-sm-4'
                     style="display:none;"><?= $form->field($model, 'has_parking')->textInput()->label(false) ?></div>

                <?php /* if(!$model->isNewRecord){ ?>
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Status') ?> </label> 
					<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->building_status='new':$model->building_status;?>
						<?= $form->field($model, 'building_status')->radioList(Yii::$app->params['buildingStatus'][Yii::$app->language])->label(false) ?>
					</div>
                <?php } */ ?>
                <div class="clearfix"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'annual income') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'annual_income')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Water Meter Number') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'water_meter_no')->textInput(['maxlength' => true])->label(false) ?></div>


                <div class="clearfix"></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Space') ?> <span class="clsReq">*</span></label>
                <div class='col-sm-4'><?= $form->field($model, 'space')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Number of Rooms') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'number_of_rooms')->textInput(['maxlength' => true])->label(false) ?></div>

                <div class="clearfix"></div>

                <!--                <label for='' class='col-sm-2 control-label'>-->
                <?php //= Yii::t('app', 'Room Type') ?><!-- <span class="clsReq">*</span></label>-->
                <!--				<div class='col-sm-4'>-->
                <?php //= $form->field($model, 'room_type')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
                <!--               -->

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Real Estate Interface') ?></label>
                <div class='col-sm-4'><?= $form->field($model, 'real_estate_interface')->textInput(['maxlength' => true])->label(false) ?></div>
                <div class="clearfix"></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Street Width') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'street_view')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Facilities') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'facilities')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Using For') ?> </label>
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


                <!--                <label for='' class='col-sm-7 control-label'>-->
                <?php //= Yii::t('app', 'Is there a mortgage or restriction that prevents or limits the disposal or use of the property?') ?><!-- <span class="clsReq">*</span></label>-->
                <!--				<div class='col-sm-2'>-->
                <?php //= $form->field($model, "limit_property")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?><!--</div>-->
                <!--                <label for='' class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'If Yes') ?><!--</label>-->
                <!--                <div class='col-sm-2'>-->
                <?php //= $form->field($model, 'limit_property_yes')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
                <!--              -->
                <!--              -->
                <!--                <label for='' class='col-sm-7 control-label'>-->
                <?php //= Yii::t('app', 'Rights and obligations over real estate not documented in the real estate document') ?><!-- <span class="clsReq">*</span></label>-->
                <!--				<div class='col-sm-2'>-->
                <?php //= $form->field($model, "document_rights")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?><!--</div>-->
                <!--                <label for='' class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'If Yes') ?><!--</label>-->
                <!--                <div class='col-sm-2'>-->
                <?php //= $form->field($model, 'document_rights_yes')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->


                <!--                <label for='' class='col-sm-7 control-label'>-->
                <?php //= Yii::t('app', 'Information that may affect the property') ?><!-- <span class="clsReq">*</span></label>-->
                <!--				<div class='col-sm-2'>-->
                <?php //= $form->field($model, "information_affects")->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?><!--</div>-->
                <!--                <label for='' class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'If Yes') ?><!--</label>-->
                <!--                <div class='col-sm-2'>-->
                <?php //= $form->field($model, 'information_affects_yes')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->
                <!--               -->


            </div>
        </fieldset>

        <fieldset>
            <legend><?= Yii::t('app', 'Building Location') ?> :</legend>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'City') ?> <span class="clsReq">*</span></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'city_id')->widget(Select2::class, ['data' => ArrayHelper::map($EOS['citys']->where(['>', 'id', 0])->all(), 'id', '_name'), 'options' => ['prompt' => Yii::t('app', 'Select City')]])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'>
                    <?= Yii::t('app', 'District') ?> <span class="clsReq">*</span>
                </label>

                <div class='col-sm-4'>
                    <?php
                    echo $form->field($model, "district_id")->widget(DepDrop::class, [

                        'data' => ($model->isNewRecord && !isset($model->city_id) ? [$model->city_id => ''] : District::ListDistrictByCar($model->city_id)),
                        'type' => DepDrop::TYPE_SELECT2,

                        'pluginOptions' => [
                            'depends' => ["building-city_id"],
                            'initialize' => true,
                            'placeholder' => Yii::t('app', 'Select District'),
                            'url' => Url::to(['/dropdown/district']),
                            'loadingText' => Yii::t('app', 'Loading district ...'),
                        ]
                    ])->label(false); ?>

                </div>
                <!--		        <div class="clearfix"></div>-->


                <!--                <label for='' class='col-sm-2 control-label'>-->
                <?php //= Yii::t('app', 'Neighborhood Name') ?><!-- <span class="clsReq">*</span></label>-->
                <!--				<div class='col-sm-4'>-->
                <?php //= $form->field($model, 'neighborhood_name')->textInput(['maxlength' => true])->label(false) ?><!--</div>-->


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Street Name') ?> </label>
                <div class='col-sm-4'><?= $form->field($model, 'street_name')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'
                       style="display:none;"><?= Yii::t('app', 'Limits and Lengths of the Property') ?> <span
                            class="clsReq">*</span></label>
                <div style="display:none;"
                     class='col-sm-4'><?= $form->field($model, 'limits_length_property')->textInput(['maxlength' => true])->label(false) ?></div>


                <div class="clearfix"></div>
                <?= Yii::$app->view->renderFile('@backend/views/layouts/map.php', ['model' => $model, 'form' => $form]); ?>

                <div class="clearfix"></div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?= Yii::t('app', 'Other Details') ?> :</legend>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Estate Details') ?></label>
                <div class='col-sm-10'>
                    <?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction' => Yii::$app->language == 'ar' ? 'rtl' : 'ltr',
                            'lang' => Yii::$app->language,
                            'buttons' => false,

                        ]
                    ])->label(false) ?>
                    <?php /*->hint("<code>" .Yii::t('app', 'write <br> for New Line')."</code>")*/ ?>
                </div>

                <div class="clearfix"></div>


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Receive Date') ?> </label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'receive_date')->widget(DatePicker::class, [
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => '23-Feb-1982',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd'
                        ],

                    ])->label(false); ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Expire Date') ?> </label>

                <div class='col-sm-4'>
                    <?= $form->field($model, 'expire_date')->widget(DatePicker::class, [
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => '23-Feb-1982',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ])->label(false); ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?= Yii::t('app', 'Rent And Sale for full Building') ?> :</legend>

            <div class='col-sm-12'>
                <div class='col-sm-4'><?= $form->field($model, 'for_rent')->checkbox(['value' => 1]) ?></div>
                <div class='col-sm-4'><?= $form->field($model, 'for_sale')->checkbox(['value' => 1]) ?></div>
                <div class='col-sm-4'><?= $form->field($model, 'for_invest')->checkbox(['value' => 1]) ?></div>
            </div>


            <div class='col-sm-12'>
                <!--			   	<label for='' style="width:120px;" class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'Rent Price') ?><!-- </label> -->
                <div class='col-sm-4'><?= $form->field($model, 'rent_price')->textInput(); ?></div>
                <!--              	<label for='' style="width:120px;" class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'Sale Price') ?><!-- </label> -->
                <div class='col-sm-4'><?= $form->field($model, 'sale_price')->textInput(); ?></div>
                <!--               	<label for='' style="width:120px;" class='col-sm-1 control-label'>-->
                <?php //= Yii::t('app', 'Invest Price') ?><!-- </label> -->
                <div class='col-sm-4'><?= $form->field($model, 'invest_price')->textInput(); ?></div>
                <!--				<div class="clearfix"></div>		-->
            </div>
        </fieldset>

        <fieldset>
            <legend><?= Yii::t('app', 'Estate Images') ?> :</legend>
            <div class='col-sm-12'>

                <div class="clearfix"></div>
                <!--<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> -->

                <div class='col-sm-12'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model' => $model, 'form' => $form, 'files' => $arrImages2]) ?>
                </div>

                <div class="clearfix"></div>
            </div>
        </fieldset>
        <!-- <fieldset style="display:none;">
		    <div class='col-sm-12'>	
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status') ?> </label> 

				<div class='col-sm-10'>
					<?php $model->isNewRecord ? $model->status = 1 : $model->status; ?>
					<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusCase'][Yii::$app->language])->label(false) ?>
				</div>
				<div class="clearfix"></div>
			</div>
        </fieldset>	 -->
        <div class="space_v"></div>
        <div class='col-sm-12'>
            <?= \common\components\HousingUnitWidget::widget(['model' => $modelsHousings, 'form' => $form]) ?>
        </div>

    </div>


    <div class="box-footer">

        <div class='col-sm-12 clsAgreeTerms' style="clear:both; width:100%;">

            <?=
            $form->field($model, 'agreeterms')->checkboxList(Yii::$app->params['agree_terms'][Yii::$app->language], [

                'class' => "btn-checkbox options",

                'data-toggle' => "button",

                'item' => function ($index, $label, $name, $checked, $value) {

                    return "<label class='clsTermlabel'><input type='checkbox' {$checked} name='{$name}' value='{$value}'><a href='javascript:;' style='color:#C6A53E;' data-toggle='modal' data-target='#myModal'>{$label}</a></label>";

                }

            ])->label(false); ?>


        </div>


        <div style="clear:both; width:100%;" class='col-sm-12'>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
if (yii::$app->user->identity->user_type == 'owner') {
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
       $('input[name*="[for_invest]"]').prop('readonly', false);
       $('input[name*="[ad_subtype]"]').prop('readonly', false);
       $('input[name*="[rent_price]"]').prop('readonly', false);
       $('input[name*="[invest_price]"]').prop('readonly', false);
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
        
        $('body').on('afterInsert', function(e, item) {
    var widgetsOptions = $(this).data('yiiDynamicForm').settings;
    var elem = $(item);
    
    alert('inderted')

    // Now you can use widgetsOptions and elem in your logic
    widgetsOptions = widgetsOptions.reverse();
    for (var i = widgetsOptions.length - 1; i >= 1; i--) {
        if (widgetsOptions[i] && widgetsOptions[i].widgetItem) {
            identifiers[i] = elem.closest(widgetsOptions[i].widgetItem).index();
        }
    }

});
       $("#building-advertiser_license_number").keyup(function() {
           value = $("#building-advertiser_license_number").val();
           
       });

    });
JS;
$this->registerJs($scripts);

?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="height:430px; overflow-y:auto;">

                <p dir="rtl" style=""><span style="">هذه الصفحة مخصصة أولا: لإيضاح الضوابط للإعلانات العقارية المقدمة من الهيئة العامة للعقار وضرورة التقيد بها</span>
                </p>

                <p dir="rtl" style=""><span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;وثانيا: لسرد الشروط والأحكام لاستخدام المنصة سواء للمسجلين وغير المسجلين وفهمها</span>
                </p>

                <p dir="rtl" style=""><span style="">يجب على المعلنين في منصة نافذة التقيد بما سنورده من شروط وضعتها الهيئة العامة للعقار كما نبين أن أي إخلال أو مخالفة لهذه الشروط والضوابط قد يترتب عليه حذف الإعلان وقد يصل إلى إيقاف الحساب&nbsp;</span>
                </p>

                <p dir="rtl" style=""><span style="">ضوابط الإعلانات العقارية&nbsp;</span></p>

                <p dir="rtl" style=""><span style="">أولا:</span></p>

                <p dir="rtl" style=""><span style="">يقصد بالعبارات والمصطلحات الآتية المعاني المبينة أمامها:</span></p>

                <p dir="rtl" style=""><span style="">1)الهيئة: الهيئة العامة للعقار.</span></p>

                <p dir="rtl" style=""><span style="">2)الإعلان العقاري: الإعلان المرئي أو المقروءة أو المسموع؛ لغرض التصرف في العقار بأي وسيلة كانت.</span>
                </p>

                <p dir="rtl" style=""><span style="">3)المعلن: طالب نشر الإعلان العقاري سواء أكان الإعلان لنفسه أم لغيره بأي وسيلة كانت.</span>
                </p>

                <p dir="rtl" style=""><span style="">4)المنصة العقارية الالكترونية: التطبيق أو الموقع الإلكتروني ونحوهم المختصة بالتسويق للإعلان العقاري.</span>
                </p>

                <p>&nbsp;</p>

                <p dir="rtl" style=""><span style="">ثانيا:</span></p>

                <p dir="rtl" style=""><span style="">دون إخلال باختصاصات الجهات ذات العلاقة، واختصاص الهيئة العامة للإعلام المرئي والمسموع يجب الالتزام في الإعلان العقاري بما يلي:</span>
                </p>

                <p dir="rtl" style=""><span style="">1) تحري الصدق والأمانة.</span></p>

                <p dir="rtl" style=""><span style="">2) الابتعاد عن كل ما يسبب التباسا أو تضليلا للعموم.</span></p>

                <p dir="rtl" style=""><span
                            style="">3) الالتزام بما يصدر به الدليل العام لضوابط المحتوى الإعلاني.</span></p>

                <p dir="rtl" style=""><span style="">4) الالتزام بما يصدر من الجهات المختصة بتنظيم المحتوى الأخلاقي والإعلامي بجميع وسائطه المعلوماتية (التقليدية والإلكترونية)</span>
                </p>

                <p dir="rtl" style=""><span style="">5) الالتزام بالأسماء الرسمية، من مدن وأحياء وشوارع وأنواع للعقارات، ويجوز إضافة الأسماء المتعارف عليها إضافة لها.</span>
                </p>

                <p dir="rtl" style=""><span style="">6) أن يحتوي على البيانات الآتية:</span></p>

                <p dir="rtl" style=""><span style="">أ. النص على كونه إعلانا</span></p>

                <p dir="rtl" style=""><span style="">ب. تحديد الغرض منه (بيع، إيجار، استثمار وغيرها)</span></p>

                <p dir="rtl" style=""><span style="">ج. تحديد نوع العقار.</span></p>

                <p dir="rtl" style=""><span style="">د. اسم المعلن وصفته (مالك أو مفوض)</span></p>

                <p dir="rtl" style=""><span style="">هـ. رقم ترخيص المعلن إن كان مكتبا أو مسوقا عقاريا أو حاصلا على وثيقة عمل حر.</span>
                </p>

                <p dir="rtl" style=""><span style="">و. موقع العقار على أن يحتوي _بحد أدنى_ (المدينة – الحي – رقم المخطط إن وجد).</span>
                </p>

                <p dir="rtl" style=""><span style="">ز. وسيلة تواصل فعَالة مع المعلن.</span></p>

                <p dir="rtl" style=""><span style="">ح. الإفصاح عن بيانات العقار وفق ما يلي:</span></p>

                <p dir="rtl" style=""><span style="">- مساحة العقار.</span></p>

                <p dir="rtl" style=""><span style="">- النزاعات القائمة بشأنه إن وجدت.</span></p>

                <p dir="rtl" style=""><span
                            style="">- الرهن أو القيد الذي يمنع أو يحد من التصرف أو الانتفاع من العقار.</span></p>

                <p dir="rtl" style=""><span style="">- الحقوق والالتزامات على العقار غير الموثقة في وثيقة العقار.</span>
                </p>

                <p dir="rtl" style=""><span style="">-الخدمات المتعلقة بالعقار.</span></p>

                <p dir="rtl" style=""><span style="">- المعلومات التي قد تؤثر في العقار سواء في خفض قيمته أو التأثير على قرار المستهدف بالإعلان، مثل الضمانات ومددها ومطابقة كود البناء السعودي والعمر للعقار القائم وغير ذلك.</span>
                </p>

                <p dir="rtl" style=""><span style="">- إن كان الإعلان عن مزاد عقاري يجب _ إضافة إلى مايصدر من الجهات ذات العلاقة _أن يتضمن رقم ترخيص المزاد، ومكانه، وشروطه، والموعد المحدد لإقامته، ومدته الزمنية، والموعد النهائي للتقدم للمزاد -إن وجد-.</span>
                </p>

                <p dir="rtl" style=""><span style="">ثالثا:</span></p>

                <p dir="rtl" style=""><span style="">أن يحتوي الإعلان العقاري في المنصة العقارية الالكترونية إضافة إلى البيانات الواردة في البند (ثانيا) على البيانات الآتية:</span>
                </p>

                <p dir="rtl" style=""><span style="">1) وصف العقار بما يشمل نوعه وعمره ومحتوياته وأي وصف مؤثر مثل: عرض الشارع الواقع عليه، وواجهة العقار وغيرها.</span>
                </p>

                <p dir="rtl" style=""><span style="">2) حدود وأطوال العقار.</span></p>

                <p dir="rtl" style=""><span style="">3) ثمن العقار.</span></p>

                <p dir="rtl" style=""><span style="">رابعا:</span></p>

                <p dir="rtl" style=""><span style="">دون إخلال باختصاصات الجهات ذات العلاقة يحظر تضمين الإعلان العقاري أيا مما يأتي:</span>
                </p>

                <p dir="rtl" style=""><span style="">1) مخالفة للتعليمات الإسلامية أو للأنظمة والتعليمات في المملكة أو للأعراف السائدة.</span>
                </p>

                <p dir="rtl" style=""><span style="">2) خدشا للحياء.</span></p>

                <p dir="rtl" style=""><span style="">3) انتهاكا لحقوق الملكية الفكرية.</span></p>

                <p dir="rtl" style=""><span
                            style="">4) التعرض بصورة سلبية للمنافسين أو منشآت القطاع الخاص أو غيرها.</span></p>

                <p dir="rtl" style=""><span style="">5) عبارات أو إشارات يفهم منها التمييز ضد أحد أيا كان.</span></p>

                <p dir="rtl" style=""><span style="">6) صورا، أو بيانات، أو موقعا، أو مناظير مضللة أو لا تخص العقار المعلن عنه.</span>
                </p>

                <p dir="rtl" style=""><span style="">7) شعار الهيئة أو اسمها أو أي من الجهات الحكومية الأخرى إلا بإذن مسبق منها.</span>
                </p>

                <p dir="rtl" style=""><span style="">خامسا:</span></p>

                <p dir="rtl" style=""><span style="">يحظر نشر الإعلانات العقارية الوهمية؛ لغرض جمع بيانات المتلقين أو العموم أو أي غرض آخر.</span>
                </p>

                <p dir="rtl" style=""><span style="">سادسا:</span></p>

                <p dir="rtl" style=""><span style="">يجب إزالة الإعلان العقاري خلال مدة لا تزيد على يومين من تاريخ تمام أو انتهاء الغرض منه.</span>
                </p>

                <p dir="rtl" style=""><span style="">سابعا:</span></p>

                <p dir="rtl" style=""><span style="">تقوم الهيئة بالرقابة على الالتزام بأحكام هذه الضوابط، وإحالة المخالفة للجهات المختصة لاتخاذ الإجراءات النظامية بشأنها.</span>
                </p>

                <p dir="rtl" style=""><span style="">ثامنا:</span></p>

                <p dir="rtl" style=""><span style="">يستثنى من تطبيق أحكام الضوابط الآتي:</span></p>

                <p dir="rtl" style=""><span style="">1) الإعلانات العقارية من الجهات الحكومية.</span></p>

                <p dir="rtl" style=""><span style="">2) إعلانات البيع أو التأجير على الخارطة.</span></p>

                <p dir="rtl" style=""><span
                            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">الشروط والأحكام لمنصة نافذة</span>
                </p>


                <p dir="rtl" style=""><span style="">تعاريف</span></p>

                <p dir="rtl" style=""><span style="">نافذة: شركة نافذة الرقمية لإدارة الأملاك.</span></p>

                <p dir="rtl" style=""><span style="">المنصة: موقع إلكتروني على شبكة الإنترنت تقدم نافذة من خلاله خدمات إلكترونية.</span>
                </p>

                <p dir="rtl" style=""><span style="">المستخدم: أي شخص يستفيد من الخدمات الإلكترونية التي تقدمها نافذة من خلال المنصة سواء كان أصيل أو ممثل مسجلاً أو غير مسجل</span>
                </p>


                <p dir="rtl" style=""><span style="">مقدمة</span></p>

                <p dir="rtl" style=""><span style="">تقدم منصة نافذة خدماتها الإلكترونية عبر المنصة الإلكترونية وهي متاحة للاستخدام من قبل الجميع.</span>
                </p>

                <p dir="rtl" style=""><span style="">يخضع دخول المستخدم واستخدامه لهذه المنصة للشروط والأحكام المذكورة في هذه الوثيقة.</span>
                </p>

                <p dir="rtl" style=""><span style="">إن الخدمات والمعلومات المتوفرة على المنصة وشروط وأحكام الاستخدام تخضع لقوانين وأنظمة المملكة العربية السعودية ومنها على سبيل المثال لا الحصر: نظام الاتصالات، نظام التعاملات الإلكترونية، نظام مكافحة الجرائم المعلوماتية، ولوائح وإجراءات المركز ذات العلاقة بأسماء النطاقات وتفسر بموجبها.</span>
                </p>

                <p dir="rtl" style=""><span style="">يعد دخول المستخدم للمنصة واستخدامها موافقة على هذه الشروط والأحكام دون قيد أو شرط.</span>
                </p>

                <p dir="rtl" style=""><span style="">التسجيل في المنصة</span></p>

                <p dir="rtl" style=""><span style="">يقتضي استخدام الخدمات الإلكترونية التسجيل في المنصة، علماً بأنه ليست هناك رسوم لعملية التسجيل في المنصة حالياً، وفي القريب ستوفر المنصة عدة باقات تتناسب مع عملائها.</span>
                </p>


                <p dir="rtl" style=""><span style="">التزامات المستخدم</span></p>

                <p dir="rtl" style=""><span style="">يقر المستخدم بأن أي معلومات يقدمها عبر المنصة هي معلومات كاملة ودقيقة ومحدثة. كما يتحمل المسؤولية عن محتوى أي معلومة أو وثيقة يتم تقديمها من خلال المنصة.</span>
                </p>

                <p dir="rtl" style=""><span style="">يتحمل المستخدم المسئولية الكاملة في حالة انتحاله اسم مستخدم آخر ويحق لشركة نافذة الرقمية إيقاف الاشتراك في حال اكتشاف الانتحال مع اتخاذ الاجراءات النظامية حيال ذلك.</span>
                </p>

                <p dir="rtl" style=""><span style="">يقر المستخدم بأنه لن يقوم بتمثيل أي شخص طبيعي أو معنوي من دون أن يكون مخولاً بذلك.</span>
                </p>

                <p dir="rtl" style=""><span style="">يقر المستخدم بأن دخول المنصة واستخدامه لها سيكون لأغراض مشروعة فقط، ويلتزم بعدم استخدام المنصة أو ما يتوفر عليها من معلومات أو خدمات أو أدوات للقيام بأي عمل ينتج عنه مخالفة أو جريمة بموجب أي نظام ساري المفعول في المملكة العربية السعودية، وذلك بغض النظر عمن وجهت إليه تلك المخالفة أو ذلك الجرم.</span>
                </p>


                <p dir="rtl" style=""><span style="">المحتوى</span></p>

                <p dir="rtl" style=""><span style="">إن اسم نافذة (شركة نافذة الرقمية لإدارة الأملاك) وشعارها وعناوينها وكل ما تتضمنه المنصة على سبيل المثال لا الحصر من مواد ونصوص وصور ورسومات وتصاميم ونماذج وملفات وسائط متعددة وبرمجيات وتبويبها هو ملك لنافذة وتحتفظ نافذة بكافة حقوق الملكية الفكرية المتعلقة بها بما في ذلك حقوق النشر والتوزيع، ولا يسمح بإعادة طبع هذه المواد، أو توزيعها، أو تعديلها، أو استخدامها لأغراض تجارية، أو دعائية، أو إعادة نشرها بأي شكل دون الحصول على إذن خطي وصريح من نافذة.</span>
                </p>

                <p dir="rtl" style=""><span
                            style="">تحتفظ نافذة بالحق في مراقبة أي محتوى يتم إدخاله من قبل المستخدم.</span></p>

                <p dir="rtl" style=""><span style="">تحتفظ نافذة بالحق (من دون التزام) في شطب أو إزالة أو تحرير أي مواد مدخلة من شأنها انتهاك هذه الشروط والأحكام.</span>
                </p>

                <p dir="rtl" style=""><span style="">تحتفظ نافذة بالحق في حذف أي معلومات تعتبرها انتهاكاً لأي من شروط وأحكام الاستخدام دون إشعار.</span>
                </p>

                <p dir="rtl" style=""><span style="">إن المحتويات والأدوات على المنصة مقدمة للمستخدمين كما هي، من دون ضمانات من أي نوع، سواء كانت صريحة أو ضمنية.</span>
                </p>

                <p dir="rtl" style=""><span style="">قد تقود بعض الروابط على البوابة إلى مواقع إلكترونية لا يتم تشغيلها من قبل المنصة، وليس للمنصة سيطرة عليها، كما أن المنصة لا تقوم بمراجعة أو التحكم بالمحتوى الخاص بتلك المواقع، وعند اختيار المستخدم لرابط خاص بموقع خارجي، فإنه يخضع للشروط والأحكام الخاصة بذلك الموقع الخارجي.</span>
                </p>


                <p dir="rtl" style=""><span style="">تنازل عن الضمان</span></p>

                <p dir="rtl" style=""><span style="">تسعى نافذة إلى توفير إمكانية دخول آمن إلى المنصة وإلى الخدمات المقدمة من خلالها، لكن ونتيجة لعوامل خارجة عن سيطرة نافذة، فإن نافذة لا تضمن إمكانية الدخول المستمر بحرية ودون انقطاع وبشكل آمن إلى البوابة أو أي من خدماتها، كما لا تتحمل نافذة المسؤولية عن أي انقطاع أو تأخير أو خلل في الخدمات المقدمة عبر المنصة.</span>
                </p>

                <p dir="rtl" style=""><span style="">يقر المستخدم أن استخدامه للمنصة أو أي مادة متاحة من خلالها خاضع لمسؤولياته الخاصة، ولا توفر المنصة ولا أي من موظفيها ضمانة بأن المنصة لن تتعرض للتوقف أو أنها ستكون خالية من المشاكل أو الحذف أو الأخطاء، كما لا توجد ضمانة بشأن النتيجة التي سيحصل عليها المستخدم جراء استخدامه للمنصة أو التسجيل فيها.</span>
                </p>

                <p dir="rtl" style=""><span style="">لقد قامت نافذة باتخاذ كافة التدابير المناسبة لوضع المعلومات على المنصة وستحاول العمل على تحديث هذه المعلومات أولاً بأول، ومع هذا، فإن المنصة لا تمنح أي ضمانات صريحة أو ضمنية بخصوص دقة المعلومات المنشورة أو موافقتها لواقع الحال أو اكتمالها.</span>
                </p>


                <p dir="rtl" style=""><span style="">حدود المسؤولية</span></p>

                <p dir="rtl" style=""><span style="">لا تتحمل نافذة المسؤولية عن أي خسارة في الأرباح أو أي خسارة من أي نوع نتيجة للمعلومات أو الخدمات التي تقوم بتقديمها.</span>
                </p>

                <p dir="rtl" style=""><span style="">لا تتحمل نافذة المسؤولية عن أي خسارة أو تعديل أو ضرر في بيانات المستخدمين المخزنة على المنصة، مما ينشأ عنه حصول شخص غير مفوض على حق الدخول إلى بيانات المستخدم المخزنة لدى المنصة.</span>
                </p>

                <p dir="rtl" style=""><span style="">مهما كان الحال أو الظرف، فإن نافذة غير مسئولة تجاه أي من الأمور التالية على سبيل المثال لا الحصر: الإهمال الذي يتسبب في أية أضرار أو تلف من أي نوع سواء كانت مباشرة أو عارضة أو خاصة أو لاحقـة، أو أي مصاريف أو خسائر قد تنجم بسبب استخدام المستخدم للمنصة أو عدم القدرة على استخدامه إياها، أو وقوع بعض الأخطاء أو السهو أو تأخر استجابة النظام لأي سبب كان، أو إعاقة في التشغيل أو وقوع أعطال أو تعرض أجهزة الكمبيوتر للفيروسات أو تعطل النظام بالكامل، أو خسارة أي أرباح أو تعرض سمعة المستخدم للإساءة حتى لو جرى الإشعار صراحة باحتمالية وقوع مثل هذه الأمور، أو وقوع مشاكل جراء الوصول للمنصة أو الدخول إليها أو استخدامها أو الوصول من خلالها إلى مواقع أخرى.</span>
                </p>


                <p dir="rtl" style=""><span style="">التعديل</span></p>

                <p dir="rtl" style=""><span style="">يحق لنافذة تعديل هذه الشروط والأحكام أو استبدالها كليا بشروط وأحكام أخرى جديدة وإشعاركم بذلك، وتصبح التعديلات نافذة فور نشرها على المنصة ما لم يتم بيان خلاف ذلك، ويعتبر استمرارية دخول المستخدم للمنصة أو استخدامه للخدمات التي توفرها المنصة بمثابة موافقة منه على هذه التغييرات</span>
                </p>


                <p dir="rtl" style=""><span style="">حل النزاع</span></p>

                <p dir="rtl" style=""><span style="">في حال نشوء أي نزاع يقع بسبب هذه البنود، أو الشروط، أو الأحكام، أو الاستخدام يتم حله وديّا وفي حال تعذّر الحل الودي ستكون المحاكم المختصة في مدينة الرياض هي جهة الاختصاص</span>
                </p>


            </div>

            <div class="modal-footer" style="padding:5px; border:none;"></div>

        </div>
    </div>
</div>
