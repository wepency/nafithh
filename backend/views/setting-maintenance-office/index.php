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

use kartik\depdrop\DepDrop;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SettingEstateOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Setting Maintenance Offices');
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
        <fieldset>
            <div class='col-sm-12'>
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
                                    'deleteUrl' => Url::to(['maintenance-office/delete-file', 'id' => $model->id,'logo']),
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

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Description') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'description')
                ->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                </div>

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
                                    'deleteUrl' => Url::to(['estate-office/delete-file', 'id' => $model->id,'attribute' =>'footer_report_image']),
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

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Tax Num') ?> </label> 
                <div class='col-sm-4'><?= $form->field($model, 'tax_num')->textInput(['maxlength' => true])->label(false) ?></div>
                <div class="clearfix"></div>
                
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 

                <div class='col-sm-10'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                </div> 
                <div class="clearfix"></div>

        <!-- End table Setting Setate Office -->
            </div>
        </fieldset>

    </div>
    
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>