<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\RentPeriod;
use common\models\HousingUsingType;
use common\models\ContractFormEstateOffice;
use common\components\GeneralHelpers;
$EOS = yii::$app->SiteSetting->queryEOS();
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;
use kartik\file\FileInput;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Takamolat */
/* @var $form yii\widgets\ActiveForm */
?>
    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Rent Period')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'rent_period_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['rent_period']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Renter Period')]])->label(false)?>

    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Housing Using Type')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'housing_using_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['housing_using_types']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Housing Using Type')]])->label(false)
        ?>
    </div>
    <div class="clearfix"></div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract Form')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'contract_form_id')->widget(Select2::class, ['data' =>ArrayHelper::map(ContractFormEstateOffice::find()->where(['AND',['>','id',0],['estate_office_id'=> GeneralHelpers::getEstateOfficeId()]])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Contract Form')]])->label(false)
        ?>
    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Number Installments')?></label>
    <div class='col-sm-4'>
        <?php $model->isNewRecord && empty($model->number_installments) ? $model->number_installments=2:$model->number_installments;?>

        <?= $form->field($model, 'number_installments')->textInput()->label(false) ?>
    </div>

    <div class="clearfix"></div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Start Date')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'start_date')->widget(DatePicker::class,[
            'type' => DatePicker::TYPE_INPUT,
            'value' => '23-Feb-1982',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ],
            'pluginEvents' => [
                'changeDate' => new yii\web\JsExpression('function(selected) {
                var dt = new Date(selected.date); 
                dt.setFullYear(dt.getFullYear() + 1);
                $("#contract-end_date").data().datepicker.update(dt);
            }'),
            ]
        ])->label(false); ?>
    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'End Date')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'end_date')->widget(DatePicker::class,[
            'type' => DatePicker::TYPE_INPUT,
            'value' => '23-Feb-1982',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label(false);?>

    </div>

    <div class="clearfix"></div>
    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'price')->textInput()->label(false) ?>
    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price Text')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'price_text')->textInput(['maxlength' => true])->label(false) ?>
    </div>

    <div class="clearfix"></div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Ejar Contract No')?></label>
    <div class='col-sm-4'>

        <?= $form->field($model, 'contract_no_ejar')->textInput()->label(false) ?>
    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Insurance Amount')?></label>
    <div class='col-sm-4'>

        <?= $form->field($model, 'insurance_amount')->textInput()->label(false) ?>
    </div>
    <div class="clearfix"></div>


    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Brokerage Type')?></label>
    <div class='col-sm-4'>

        <?php $model->isNewRecord ? $model->brokerage_type=2:$model->brokerage_type;?>
        <?= $form->field($model, 'brokerage_type')->radioList(Yii::$app->params['brokerageType'][Yii::$app->language])->label(false) ?></div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Brokerage Value')?></label>
    <div class='col-sm-4'>

        <?= $form->field($model, 'brokerage_value')->textInput()->label(false) ?>
    </div>
    <div class="clearfix"></div>


    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Water')?></label>
    <div class='col-sm-4'>
        <?php $model->isNewRecord ? $model->include_water=0:$model->include_water;?>
        <?= $form->field($model, 'include_water')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
    </div>
    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Water Amount')?></label>
    <div class='col-sm-4'>
        <?= $form->field($model, 'water_amount')->textInput()->label(false) ?>
    </div>

    <div class="clearfix"></div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Electricity')?></label>
    <div class='col-sm-4'>
        <?php $model->isNewRecord ? $model->include_electricity=0:$model->include_electricity;?>
        <?= $form->field($model, 'include_electricity')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
    </div>

    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Maintenance')?></label>
    <div class='col-sm-4'>
        <?php $model->isNewRecord ? $model->include_maintenance=0:$model->include_maintenance;?>
        <?= $form->field($model, 'include_maintenance')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
    </div>

    <div class="clearfix"></div>
    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label>

    <div class='col-sm-10'>
        <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
    </div>
    <div class="clearfix"></div>

    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Additional File') ?> </label>
    <div class='col-sm-10'>
        <?php
        echo $form->field($model, 'file')->widget(FileInput::class, [
            'options' => ['accept' => 'any'],
            'pluginOptions' => [
                'previewFileType' => 'any',
                'showUpload' => false,
                'showRemove' => true,
                'initialPreview'=> !empty($model->file) ? $model->file : '',
                'initialPreviewAsData'=>true,
                'deleteUrl' => Url::to(['contract/delete-file', 'id' => $model->id, 'attribute' => 'file']),
            ],
        ])->label(false);  ?>
    </div>
    <div class="clearfix"></div>
    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Details')?></label>
    <div class='col-sm-10'><?= $form->field($model, 'details')->widget(Redactor::class, [
            'clientOptions' => [
                'direction'=>'rtl',
                'lang' => 'ar',
                'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

            ]
        ])->label(false)?>

    </div>



    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Terms And Conditions')?></label>
    <div class='col-sm-10'><?= $form->field($model, 'terms_and_conditions')->widget(Redactor::class, [
            'clientOptions' => [
                'direction'=>'rtl',
                'lang' => 'ar',
                'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

            ]
        ])->label(false)?>

    </div>

<?php
$url = Yii::$app->urlManager->baseUrl."/contract/contract-form";
$script = <<< JS
    var ajaxURL = '$url';
$(document).ready(function(){
    $("select[id='contract-contract_form_id']").change(function(){
        $.ajax({
            url: ajaxURL,
            type: 'GET',
            data: {'cont_form_id':$(this).children("option:selected").val()},
            success: function (data) {
                if(data.error == true)
                {
                    console.log("true");
                }else if(data.error == false){
                    $("textarea[id='contract-details']").redactor('code.set', data.content)
                  console.log("false");
                }else{
                  console.log("else errore");
                }
            },
            error: function () {
                alert("Something went wrong");
            }
        });
    });
});
JS;
$this->registerJs($script);
?>