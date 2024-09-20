<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->title = yii::t('app', 'Nafath App Validation');

?>

<!-- Start Content -->
<div class="site-content pad-50" style="min-height: 400px !important;">
    <!-- Start Contact Section -->
    <section class="contact-sec">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="title mb-5">
                        <h4>
                            <img src="<?= Yii::$app->homeUrl ?>images/pin.png">
                            <?= yii::t('app', 'Nafath App Validation') ?>
                        </h4>
                    </div>
                    <div class="col-lg-14">
                        <?php Pjax::begin([]); ?>

                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['enctype' => 'multipart/form-data', 'class' => "form-horizontal"], 'class' => 'contact-frm']); ?>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group text-center">
                                <label><?= yii::t('app', 'Nafath National Id') ?></label>
                                <?= $form->field($model, 'nationalId')->textInput(['placeholder' => yii::t('app', 'Nafath National Id Label short')])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <?= \yii\helpers\Html::submitButton(yii::t('app', 'Validate Nafath Btn'), ['class' => 'btn btn-primary custom-btn', 'name' => 'signup-button']) ?>
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