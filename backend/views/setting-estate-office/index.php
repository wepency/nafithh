<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\City;
use common\models\District;
use common\models\Nationality;    
use common\models\RentPeriod;
use common\models\HousingUsingType;
use common\models\HousingUnitType;
use common\models\BuildingType;
use common\models\IdentityType;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\Tabs;

use kartik\depdrop\DepDrop;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SettingEstateOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$EOS = yii::$app->SiteSetting->queryEOS();

$this->title = Yii::t('app', 'Setting Estate Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .label-data{
        color: #20a5a0;
        font-size: 16px;
        padding-top: 5px;
    }
</style>
<div class="setting-estate-office-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
        <?php $this->beginBlock('contact'); ?>

            <fieldset>
                <div class='col-sm-12'>
                    <legend><?=Yii::t('app','Contact Info')?> :</legend>
                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name Office') ?> </label> 

                    <div class='col-sm-4 form-group'>
                        <label class='label-data'><?= $model->name ?></label>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Auth Person') ?> </label> 
                    <div class='col-sm-4 form-group'>
                        <label class='label-data'><?= $model->auth_person ?></label>
                    </div>
                    <div class="clearfix"></div>

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
                    <div class="clearfix"></div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Registration Code') ?> </label> 
                    <div class='col-sm-4 form-group'>
                        <label class='label-data'><?= $model->registration_code ?></label>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Registration Date') ?> </label> 
                    <div class='col-sm-4 form-group'>
                        <label class='label-data'><?= $model->registration_date ?></label>
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

                    <div class="clearfix"></div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'SMS Balance Type')?></label>
                    <div class='col-sm-4'>
                        <?= $form->field($model, 'sms_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language],['itemOptions'=>['disabled' => true]])->label(false) ?>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract Balance Type')?></label>
                    <div class='col-sm-4'>
                        <?= $form->field($model, 'contract_default_type')->radioList(Yii::$app->params['defaultBalanceType'][Yii::$app->language],['itemOptions'=>['disabled' => true]])->label(false) ?>
                    </div>

                    <div class="clearfix"></div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sms Balance') ?> </label> 
                    <div class='col-sm-4'><?= $form->field($model, 'sms_balance')->textInput(['disabled' => true])->label(false) ?></div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Contract Balance') ?> </label> 
                    <div class='col-sm-4'>
                        <?= $form->field($model, 'contract_balance')->textInput(['disabled' => true])->label(false) ?>
                    </div>
                    
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

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Description') ?> </label> 

                    <div class='col-sm-10'><?= $form->field($model, 'description')->widget(Redactor::class, [
                            'clientOptions' => [
                                'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                                'lang' => Yii::$app->language,
                                'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                            ]
                            ])->label(false)?>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'City ID') ?> </label> 

                    <div class='col-sm-4'>
                        <?= $form->field($model, 'city_id')->widget(Select2::class, ['data' =>ArrayHelper::map(City::find()->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select City')]])->label(false)?>
                    </div>

                    <label for='' class='col-sm-2 control-label'>
                        <?= Yii::t('app', 'District ID') ?>
                    </label> 

                    <div class='col-sm-4'>
                        <?php
                                echo $form->field($model, "district_id")->widget(DepDrop::class, [
                                        'data'=> ($model->isNewRecord ? [$model->city_id=>''] : District::ListDistrictByCar($model->city_id)),
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
                                        'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id,'attribute' =>'header_report_image']),
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
                                        'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id,'attribute' => 'footer_report_image']),
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
                        <?= DatePicker::widget([
                            'model' => $model,
                            'disabled' => true,
                            'attribute' => 'expire_date',
                            //'form' => $form,
                            //'options' => ['placeholder' => yii::t('app','Expire Date')],
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '23-Feb-1982',
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]); ?>
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    
                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 

                    <div class='col-sm-10'>
                        <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                    </div> 
                    <div class="clearfix"></div>
                </div>
            </fieldset>
        <?php $this->endBlock(); ?>
        <?php $this->beginBlock('global_setting'); ?>
            <div class="space_v"></div>
            <fieldset>
                <legend><?=Yii::t('app','Global Setting')?> :</legend>
                <div class='col-sm-12'>
                    <div class="row">
                        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'payment Method') ?> </label> 
                        <?php 
                         foreach ($model->getListPaymentMethod() as $key => $value) { 
                            // print_r($model->getListPaymentMethod()); die(); ?>
                        <div class='col-sm-2'>
                            <?php $model->isNewRecord ? $model->{$value} = 1 : $model->{$value};?>
                            <?= $form->field($model, $value)->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                    <!-- start table Setting Setate Office -->
                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Citys')?></label>
                    <div class='col-sm-4'>
                            <?php 
                            $modelSetting->citys = (is_array($modelSetting->citys) ? $modelSetting->citys : explode( ",",$modelSetting->citys));
                            // print_r($modelSetting->citys); die();
                           echo $form->field($modelSetting, 'citys')->widget(Select2::class, [
                                'data' => ArrayHelper::map(City::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Citys'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                   
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Nationalities')?></label>
                    <div class='col-sm-4'>
                        <?php 
                            $modelSetting->nationalities = (is_array($modelSetting->nationalities) ? $modelSetting->nationalities : explode( ",",$modelSetting->nationalities));
                           echo $form->field($modelSetting, 'nationalities')->widget(Select2::class, [
                                'data' => ArrayHelper::map(Nationality::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Nationalities'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                    </div>
                    <div class="clearfix"></div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Identities')?></label>
                    <div class='col-sm-4'>
                        <?php 
                            $modelSetting->identities = (is_array($modelSetting->identities) ? $modelSetting->identities : explode( ",",$modelSetting->identities));
                           echo $form->field($modelSetting, 'identities')->widget(Select2::class, [
                                'data' => ArrayHelper::map(IdentityType::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Identities'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Building Types')?></label>
                    <div class='col-sm-4'>
                         <?php 
                            $modelSetting->building_types = (is_array($modelSetting->building_types) ? $modelSetting->building_types : explode( ",",$modelSetting->building_types));
                           echo $form->field($modelSetting, 'building_types')->widget(Select2::class, [
                                'data' => ArrayHelper::map(BuildingType::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Building Types'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                    </div>
                    <div class="clearfix"></div>
                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Housing Using Types')?></label>
                    <div class='col-sm-4'>
                        <?php 
                            $modelSetting->housing_using_types = (is_array($modelSetting->housing_using_types) ? $modelSetting->housing_using_types : explode( ",",$modelSetting->housing_using_types));
                           echo $form->field($modelSetting, 'housing_using_types')->widget(Select2::class, [
                                'data' => ArrayHelper::map(HousingUsingType::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Housing Using Types'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                    </div>
                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Rent Period')?></label>
                    <div class='col-sm-4'>
                        <?php 
                            $modelSetting->rent_period = (is_array($modelSetting->rent_period) ? $modelSetting->rent_period : explode( ",",$modelSetting->rent_period));
                           echo $form->field($modelSetting, 'rent_period')->widget(Select2::class, [
                                'data' => ArrayHelper::map(RentPeriod::find()->all(),'id','_name'),
                                'options' => [
                                    'placeholder' => Yii::t('app','Rent Period'),
                                     'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 50
                                ],
                            ])->label(false);?>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'days before notification merit')?></label>
                    <div class='col-sm-4'>
                    <?= $form->field($modelSetting, 'days_before_noti_merit')->textInput()->label(false) ?>
                    </div>

            <!-- End table Setting Setate Office -->
               </div>
            </fieldset>
        <?php $this->endBlock(); ?>

        <?php echo Tabs::Widget([
            'tabContentOptions' => [
                'class'=>'pad',
            ],
            'items' => [
                [
                    'label' => yii::t('app','Contact Info'),
                    'content' => $this->blocks['contact'],
                    'active' => true,
                ],
                [
                    'label' => yii::t('app','Global Setting'),
                    'content' => $this->blocks['global_setting'],
                ], 
            ]
        ]); ?>

    </div>
    
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>