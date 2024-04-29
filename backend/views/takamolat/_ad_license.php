<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

//$Group = \common\components\GeneralHelpers::listUserAndOfficeByCurrent('owner');
//$Group = ArrayHelper::map($Group, 'id', 'id');
//$list = \common\models\User::find()->where(['id' => $Group])->all();
// $list = \common\models\User::find()->where(['or',['user_type'=>'owner'],['owner'=>1]])->all();
//$list = ArrayHelper::map($list, 'identity_id', 'name');

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body table-responsive">

    <h5 class="text-muted"><?= Yii::t('app', 'Please enter the data below to register the ad.') ?></h5>

    <fieldset>
        <legend><?= Yii::t('app', 'License Information') ?> :</legend>

        <div class='col-sm-12'>

            <div class="col-sm-2">
                <label for='adLicenseNumber' class='control-label required'><?= Yii::t('app', 'adLicenseNumber') ?></label>
            </div>

            <div class='col-sm-4'>
                <?= $form->field($model, 'adLicenseNumber')->textInput([
                        'id' => 'adLicenseNumber',
                        'placeholder' => 'xxxxxxxxxx',
                        'required' => true
                ])->label(false) ?>
            </div>

        </div>

        <div class='col-sm-12'>

            <div class="col-sm-2">
                <label for='adLicenseId' class='control-label required'><?= Yii::t('app', 'advertiserId') ?></label>
            </div>

            <div class='col-sm-4'>
                <?= $form->field($model, 'adLicenseId')->textInput([
                        'id' => 'adLicenseId',
                        'placeholder' => 'xxxxxxxxxx',
                        'required' => true
                ])->label(false) ?>
            </div>

            <div class="col-sm-12">

                <?= Html::button('<span class="fa fa-upload" style="margin-left: 10px"></span>' . Yii::t('app', 'send'), ['class' => 'button button-primary', 'id' => 'post-takamolat', 'type' => 'button']) ?>

                <?= Html::button(Yii::t('app', 'Clear'), ['class' => 'button button-outline-success d-none', 'id' => 'clear-fields', 'type' => 'button']) ?>

            </div>
        </div>
    </fieldset>

    <div id="ad-content"></div>
</div>

<div class="box-footer mt-5">
    <?= Html::button(Yii::t('app', 'Next') . '<i class="glyphicon glyphicon-chevron-left"></i> ', [
        'class' => 'button button-primary mt-5 loadMainContent'
    ]) ?>
</div>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg-ick3BgA97MfR3EDax7psToQ8lK77Dg&libraries=places"></script>-->

<script>
    let isUpdate =  <?= isset($model->id) ? 1 : 0 ?>;
</script>

<?php
$script = <<< JS

    
$(document).ready(function(){
// checkOrAdd();
    
    $("body").on("click", "#post-takamolat", function (event) {
        event.preventDefault();
        
        const btn = $(this);

        const adLicenseNumber = $('#adLicenseNumber').val();
        const adLicenseId = $('#adLicenseId').val();
        
        if (!adLicenseNumber || !adLicenseId) {
            Swal.fire({
              icon: "error",
              title: "معلومات غير كاملة",
              text: "يرجى إدخال رقم الرخصة ورقم الهوية"
            });
            
            enableButton(btn)
            
        }else {
            getTakamolatData(adLicenseNumber, adLicenseId, btn, isUpdate);
            
        //     $.ajax({
        //     // url: '/admin/takamolat/post-request',
        //     url: '/web/admin/takamolat/post-request',
        //     type: 'POST',
        //     data: {
        //         'adLicenseNumber': adLicenseNumber,
        //         'adLicenseId': adLicenseId
        //     },
        //     success: function (data) {
        //         $('#smartwizard').smartWizard("loader", "hide");
        //         // $('#smartwizard').smartWizard("content", data);
        //        
        //         $('#ad-content').html(data.viewContent);
        //        
        //         $('#clear-fields').show();
        //            
        //         btn.attr('disabled', false).removeClass('loading').find('span').remove()
        //     },
        //     fail: function (data) {
        //         enableButton(btn)
        //     }
        // })
      }
   
    });
    
    const adLicenseNumber = $('#adLicenseNumber').val();
    const adLicenseId = $('#adLicenseId').val();
        
    if (adLicenseNumber != '') {
        getTakamolatData(adLicenseNumber, adLicenseId);
    }
   
    $('body').on('click', '#clear-fields', function(){
        $('#ad-content').empty();
        $(this).attr('disabled', false).hide().removeClass('loading').find('span').remove()
    });
});

function getTakamolatData(adLicenseNumber, adLicenseId, btn = null, isUpdate = false) {
    $.ajax({
            url: '/admin/takamolat/post-request',
            // url: '/web/admin/takamolat/post-request',
            type: 'POST',
            data: {
                'adLicenseNumber': adLicenseNumber,
                'adLicenseId': adLicenseId,
                isUpdate: isUpdate
            },
            success: function (data) {
                
                $('#smartwizard').smartWizard("loader", "hide");
                // $('#smartwizard').smartWizard("content", data);
                
                if (data.success === false) {
                    
                    Swal.fire({
                        icon: 'error',
                        title: data.error
                    });
                    
                }else {
                    $('#ad-content').html(data.viewContent);
                    $('#clear-fields').show();
                }
                
                if (btn) {
                    btn.attr('disabled', false).removeClass('loading').find('span').remove()
                }
                
            },
            fail: function (data) {
                enableButton(btn)   
            }
        })
}


JS;
$this->registerJs($script);
?>
