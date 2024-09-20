<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MaintenanceType;
use common\models\MaintenanceOffice;
use yii\helpers\ArrayHelper;
use yii\redactor\widgets\Redactor;
use kartik\select2\Select2;
use common\models\City;
use common\models\District;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */
/* @var $form yii\widgets\ActiveForm */

// if current user is Estate Office OR is owner,renter 
$user = Yii::$app->user->identity;
if (in_array($user->user_type, ['owner', 'renter', 'developer'])) {
    $senderTo = ['maintenance_officer' => Yii::t('app', 'Maintenance Office')
        , 'estate_officer' => Yii::t('app', 'Estate Office')
    ];
} else {
    $senderTo = ['maintenance_officer' => Yii::t('app', 'Maintenance Office')];
}
?>


<div class="order-info-form box box-primary">

    <?php $form = ActiveForm::begin(['options' => ['class' => "form-horizontal", 'enctype' => 'multipart/form-data']]); ?>

    <div class="box-body table-responsive">
        <fieldset>
            <div class='col-sm-12'>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Title') ?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Send To') ?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'send_to')->widget(Select2::class, ['data' => $senderTo, 'options' => ['prompt' => Yii::t('app', 'Send To'),

                    ]])->label(false) ?>
                </div>
                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Maintenance Type') ?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'maintenance_type_id')->widget(Select2::class, ['data' => ArrayHelper::map(MaintenanceType::find()->where(['>', 'id', 0])->all(), 'id', '_name'), 'options' => ['prompt' => Yii::t('app', 'Select Maintenance Type')]])->label(false) ?>
                </div>

                <div class='estate'>
                    <label for='' class='col-sm-2 control-label' style=""><?= Yii::t('app', 'Estate Office') ?></label>
                    <div class='col-sm-4' style="">
                        <label class='label-data estate_office'><?= $estateOfficeName ?? '' ?></label>
                    </div>
                </div>

                <div class='clearfix'></div>

                <div class='col-sm-12 maintenance'>
                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Maintenance Office') ?></label>
                    <div class='col-sm-3'>
                        <?= Select2::widget([
                            'name' => 'city_id',
                            'id' => 'city_id',
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                            'data' => ArrayHelper::map(City::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                            'options' => ['placeholder' => Yii::t('app', 'Select City'), 'prompt' => Yii::t('app', 'Select City')]
                        ]); ?>
                    </div>

                    <!--   <div class='col-sm-3'>
                        <?= DepDrop::widget([
                        'name' => 'district_id',
                        'id' => 'district_id',
                        'data' => District::ListDistrictByCar(),
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => [
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ],
                        'options' => ['placeholder' => Yii::t('app', 'Select District')],
                        'pluginOptions' => [
                            'depends' => ["city_id"],
                            'initialize' => false,
                            'placeholder' => Yii::t('app', 'Select District'),
                            'url' => Url::to(['/dropdown/district']),
                            'loadingText' => Yii::t('app', 'Loading district ...'),
                        ]
                    ]); ?>


                    </div> -->
                    <div class='col-sm-4'>
                        <?php
                        echo $form->field($model, "maintenanceOffice")->widget(DepDrop::class, [
                            'data' => ArrayHelper::map(MaintenanceOffice::find()->all(), 'id', 'name'),
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => [
                                'pluginOptions' => [
                                    'multiple' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ]
                            ],
                            'options' => ['placeholder' => Yii::t('app', 'Maintenance Office')],
                            'pluginOptions' => [
                                'depends' => ["city_id", "district_id"],
                                'params' => ["city_id", "district_id"],
                                'initialize' => false,
                                'placeholder' => Yii::t('app', 'Maintenance Office'),
                                'url' => Url::to(['/dropdown/maintenance']),
                                'loadingText' => Yii::t('app', 'Loading ...'),
                            ]
                        ])->label(false); ?>

                        <?php /*$form->field($model, 'maintenanceOffice')->widget(Select2::class, [
                            'data' => ArrayHelper::map(MaintenanceOffice::find()->all(),'id','name'),
                            'options' => ['placeholder' => Yii::t('app','Maintenance Office'), 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                            ])->label(false); */ ?>
                    </div>
                </div>


                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Details Order') ?></label>
                <div class='col-sm-10'>
                    <?= $form->field($model, 'details_order')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction' => Yii::$app->language == 'ar' ? 'rtl' : 'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor', 'imagemanager', 'counter', 'definedlinks', 'filemanager', 'fontcolor', 'fontfamily', 'fontsize', 'fullscreen', 'limiter', 'table', 'textdirection', 'textexpander']

                        ]
                    ])->label(false) ?>
                </div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label>

                <div class='col-sm-10'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model' => $model, 'form' => $form, 'files' => $arrImages2]) ?>
                </div>

                <div class='clearfix'></div>

            </div>
        </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php
        if ($model->is_draft === 1 || $model->isNewRecord) {
            echo Html::Submitbutton(Yii::t('app', 'Save As Draft'), [
                'class' => 'btn btn-default',
                'data' => ['method' => 'post', 'params' => ['is_draft' => true]],
            ]);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
$(document).ready(function(){
     mainOff = $(".maintenance");
    estateOff = $(".estate");
    val = $(".select2-hidden-accessible").children("option:selected").val()
    function checkSendTo(value) {
        console.log(value);
        switch(value) {
            case "estate_officer":
                hideEv(mainOff);
                showEv(estateOff);
                break;
            case "maintenance_officer":
                showEv(mainOff);
                hideEv(estateOff);
                break;
            default:
                showEv(mainOff);
                hideEv(estateOff);
        }
    }

    function hideEv(elem) {elem.hide();}
    function showEv(elem) {elem.show();}

    $("#orderinfo-send_to").change(function(){
        checkSendTo($(this).children("option:selected").val());
    });
    checkSendTo(val);
});
JS;
$this->registerJs($script);
?>
<!-- <script type="text/javascript">
    function function_name(argument) {
        // body...
    }
    value = $(this).children("option:selected").val();
                    mainOff = $(".field-orderinfo-maintenanceoffice");
                    estateOff = $(".estate_office");
                    switch(value) {case "estate_officer":hideEv(mainOff);showEv(estateOff);break;case "maintenance_officer":showEv(mainOff);hideEv(estateOff);break;default:hideEv(mainOff);hideEv(hous);hideEv(owner);}function hideEv(elem) {elem.parent().prev().hide();elem.parent().hide();}function showEv(elem) {elem.parent().prev().show();elem.parent().show();}
</script> -->