<?php
$this->title = Yii::t('app', 'Order');
$siteSetting = yii::$app->SiteSetting->info();

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

//$this->registerJs(
//    '$("document").ready(function(){
//        $("#orderForm").on("pjax:end", function() {
//            alert("Hello");
//        });
//    });'
//);

?>


<div class="site-content pad-50">
    <!-- Start Contact Section -->
    <section class="contact-sec">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                    <?php Pjax::begin([]); ?>

                    <div class="title mb-5">
                        <h4>
                            <img src="<?= Yii::$app->homeUrl ?>images/pin.png">
                            <?= yii::t('app', 'Subscribe') ?>
                        </h4>
                        <p class="text-justify"> <?= yii::t('app', 'To Subscripe in the System, please fill in the following fields') ?></p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                        <div class="info">
                            <!-- <div class="info-title">
                                <span>سعر العقار</span>
                                <h4>120000 SR</h4>
                            </div> -->
                            <div class="owner-info">
                                <!-- <h5>طلب استعلام عن العقار</h5> -->
                                <!-- <p class="small">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ</p> -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label><?= yii::t('app', 'Plan Name') ?></label>
                                            <input type="text" name="" class="form-control" disabled=""
                                                   value="<?= $model->plan->_title ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label><?= yii::t('app', 'Plan Price') ?></label>
                                            <input type="text" name="" class="form-control" disabled=""
                                                   value="<?= $model->plan->price ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label><?= yii::t('app', 'Account Number') ?></label>
                                            <input type="text" name="" class="form-control" disabled=""
                                                   value="<?= $siteSetting->account_number ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label><?= yii::t('app', 'Iban Number') ?></label>
                                            <input type="text" name="" class="form-control" disabled=""
                                                   value="<?= $siteSetting->iban_number ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label><?= yii::t('app', 'Bank Name') ?></label>
                                            <input type="text" name="" class="form-control" disabled=""
                                                   value="<?= $siteSetting->bank_name ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new -->
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">

                        <?php if (Yii::$app->session->hasFlash('success')) { ?>
                            <div class="modal fade" style="z-index: 999999999999 !important;" id="modal-succes"
                                 tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="alert alert-success alert-dismissable">
                                                <?= Yii::$app->session->getFlash('success') ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal"><?= yii::t('app', 'Close') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $("#modal-succes").modal("show");
                            </script>
                        <?php } ?>
                        <?php if (Yii::$app->session->hasFlash('error')) { ?>
                            <div class="alert alert-warning alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close btn" type="button">×
                                </button>
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'options' => ['method' => 'post', 'enctype' => 'multipart/form-data', 'data' => ['pjax' => true], 'id' => 'orderForm'],
                        'fieldConfig' => [
                            'inputOptions' => ['class' => 'form-control'],
                            'labelOptions' => ['class' => 'form-label'],
                            'options' => ['class' => 'form-group'],
                        ],
                    ]); ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?= $form->field($model, 'company_name')->textInput(['placeholder' => yii::t('app', 'Company Name')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?= $form->field($model, 'name')->textInput(['placeholder' => yii::t('app', 'Name')]) ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?= $form->field($model, 'company_type')->dropDownList(
                                Yii::$app->params['company_type'][Yii::$app->language],
                                ['prompt' => yii::t('app', 'Select Company Type'), 'placeholder' => yii::t('app', 'Company Type')]
                            ) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?= $form->field($model, 'mobile')->textInput(['placeholder' => yii::t('app', 'Mobile')]) ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?= $form->field($model, 'email')->textInput(['placeholder' => yii::t('app', 'Email')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?php echo $form->field($model->detail_field, 'sender_name')->textInput(['placeholder' => yii::t('app', 'Sender Name')]) ?>
                            <?php /*echo $form->field($model, 'detail_field[sender_name]',['options'=>['aria-required'=>'true','class'=>'required form-group']])->textInput(['placeholder' => yii::t('app', 'Sender Name'),'aria-required'=>'true'])->label( yii::t('app', 'Sender Name'))*/ ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <?php /*echo $form->field($model, 'detail_field[amount]')->textInput(['type'=>'number','placeholder' => yii::t('app', 'Amount')])->label(yii::t('app', 'Amount'))*/ ?>
                            <?php echo $form->field($model->detail_field, 'amount')->textInput(['type' => 'number', 'placeholder' => yii::t('app', 'Amount')])->label(yii::t('app', 'Amount')) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group ">
                                <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => ''])->label(yii::t('app', 'Attachement')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <?= Html::submitButton(yii::t('app', 'Send'), ['class' => 'btn btn-light custom-btn btn-submit']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->
</div>
<!-- End Content -->