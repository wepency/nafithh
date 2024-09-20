<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\Setting;
/* @var $this yii\web\View */
/* @var $model common\models\InstallmentReceiptCatch */
/* @var $form yii\widgets\ActiveForm */
$list = [];
$contract = $model->installment->contract;
$renter = $model->installment->renter;
?>
<div class="installment-receipt-catch-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>""]]); ?>
        <?=Html::activeHiddenInput($model, "installment_id"); ?>

     <div class="box-body table-responsive">
        <?php if(isset($contract->owner) && !empty($contract->owner)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/owner/_info-owner.php',['owner'=>$contract->owner]);?>
        <?php } ?>
        <?php if(isset($renter) && !empty($renter)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/renter/_info-renter.php',['renter'=>$renter]);?>
        <?php } ?>

        <?php if(yii::$app->user->identity->user_type == 'renter' ){ ?>
            <fieldset>
                <legend><?=Yii::t('app', 'Bank Accounts')?></legend>
                    <div class='col-sm-12'> 
                    <?php if($estatOffice->bankAccountOffice){?>
                        <label class='label-data col-3'></label>
                        <label class='label-data col-3'><?=Yii::t('app', 'not Account')?></label>
                        <hr>

                    <?php }else{ ?>
                        <div class='clearfix'></div>

                        <?php foreach ($estatOffice->bankAccountOffice as $key) { ?>

                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Bank Name') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->bank_name ?></div>

                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Bank Name En') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->bank_name_en ?></div>
                            <div class='clearfix'></div>

                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Account Number') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->account_number ?></div>
                            
                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Iban') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->iban ?></div>
                            <div class='clearfix'></div>

                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner Account Name') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->owner_account_name ?></div>

                            <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner Account Name En') ?> </label> 

                            <div class='col-sm-4 label-data'><?= $key->owner_account_name_en ?></div>
                            <div class='clearfix'></div>
                            <hr>

                        <?php } ?>

                    <?php } ?>
            </fieldset>
             <fieldset>
            <div class='col-sm-12'>
                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Contract No')?></label>
                <div class='col-sm-9'>
                   <label class='label-data'><?= $contract->contract_no ?></label> 
                </div>

                <?php $list[Setting::INSTALLMENT_DEPOSIT_BANK] = Yii::$app->params['PayMethod'][Yii::$app->language][Setting::INSTALLMENT_DEPOSIT_BANK]; ?>
                    
                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Payment Method')?></label>
                <div class='col-sm-9'>
                    <?= $form->field($model, 'payment_method')->radioList($list)->label(false) ?>
                </div>
                <div class="clearfix"></div>
                
                <?php /*
                        <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Payment Status')?></label>
                        <div class='col-sm-9'>
                        <?= $form->field($model, 'payment_status')->radioList([1=> Yii::$app->params['statusPayment'][Yii::$app->language][1],2=>Yii::$app->params['statusPayment2'][Yii::$app->language][2]])->label(false) ?>
                        </div>
                */?>
                


                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Received amount')?></label>
                <div class='col-sm-9'>
                <?= $form->field($model, 'amount_paid')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Other Details')?></label>
                <div class='col-sm-9'>
                <?= $form->field($model, 'details')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                </div>

                <div class="clearfix"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 
                <div class='col-sm-12'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                </div>
            </div>
        </fieldset>
        
        <?php }else{ ?>

        <fieldset>
            <div class='col-sm-12'>
                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Contract No')?></label>
                <div class='col-sm-9'>
                   <label class='label-data'><?= $contract->contract_no ?></label> 
                </div>

                <?php foreach ($estatOffice->getListAvailablePaymentMethod() as $key => $value) { 
                    $list[$key] = Yii::$app->params['PayMethod'][Yii::$app->language][$key]; ?>
                <?php } ?>
                    
                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Payment Method')?></label>
                <div class='col-sm-9'>
                    <?= $form->field($model, 'payment_method')->radioList($list)->label(false) ?>
                </div>
                <div class="clearfix"></div>
                
                <?php /*
                        <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Payment Status')?></label>
                        <div class='col-sm-9'>
                        <?= $form->field($model, 'payment_status')->radioList([1=> Yii::$app->params['statusPayment'][Yii::$app->language][1],2=>Yii::$app->params['statusPayment'][Yii::$app->language][2]])->label(false) ?>
                        </div>
                */?>

                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Received amount')?></label>
                <div class='col-sm-9'>
                <?= $form->field($model, 'amount_paid')->textInput()->label(false) ?>
                </div>

                <label for='' class='col-sm-3 control-label'><?=Yii::t('app', 'Other Details')?></label>
                <div class='col-sm-9'>
                <?= $form->field($model, 'details')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?=Yii::t('app','Attachments')?> :</legend>
            <div class='col-sm-12'> 
                
                <div class="clearfix"></div>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 
                <div class='col-sm-12'>
                    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2,'hidden_remove'=> true])?>
                </div>
                
                <div class="clearfix"></div>
            </div>
        </fieldset> 
        <?php } ?>
    </div>
    <?php if (!Yii::$app->request->isAjax){ ?>

        <div class="box-footer">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>

</div>
<?php 
$script = <<< JS

     $('input[name="InstallmentReceiptCatch[payment_method]"]').click(function(){
        $('.account').show();
        // console.log("habilitando "+$(this).data("class"));
    });


JS;
$this->registerJs($script);
