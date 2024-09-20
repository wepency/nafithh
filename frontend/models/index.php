<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->SiteSetting->siteName();
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

    <!-- Start Content -->
    <div class="site-content padt-50">
        <!-- Start Login Section -->
        <section class="login-sec">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-lg-5 offset-lg-1 col-md-12 col-sm-12 col-12 login-div">
                        <div class="login-frm-div">
                            <div class="title mb-4">
                                <h4>
                                    <img src="images/pin.png">
                                   <?= yii::t('app','Login')?>
                                </h4>
                            </div>
                            <?php $form = ActiveForm::begin([/*'action'=>['login'],*/
                                'options' => ['method' => 'post','class'=>'form-group'],
                            ]); ?> 
                                <div class="form-group">
                                    <label><?= yii::t('app','User Name')?></label>
                                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>Yii::t('app','User Name'),'class'=>'form-control'])->label(false) ?>

                                </div>
                                <div class="form-group">
                                    <label><?= yii::t('app','Passward')?></label>
                                    <?= $form->field($model, 'password')->textInput(['autofocus' => true,'class'=>'form-control'])->label(false)->passwordInput() ?>
                                </div>
                                <div class="row mb-25">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="custom-control custom-checkbox">
                                            <?= $form->field($model, 'rememberMe')->checkbox(['class' =>'custom-control-input' ])->label('<label class="custom-control-label" for='.Html::getInputId($model,"rememberMe").'>'.yii::t("app","Remember My Account Info").'</label>') ?> 
                                           
                                        </div>  
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-left">
                                        <a href="<?=Yii::$app->homeUrl?>site/request-password-reset" class="forget-pass"><?= yii::t('app','Did You Forget Your Password ?')?></a>   
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                <?= Html::submitButton(yii::t('app','Login'), ['class' => 'btn btn-light custom-btn']) ?>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="small yellow-color text-center"> <?= yii::t('app','You Can Subscribe Or')?> <a href="<?=Yii::$app->homeUrl?>site/signup"><?= yii::t('app','Create New Account')?></a></p>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mp-0">
                        <!-- Start slider -->
                        <section class="slider" id="slider">
                            <div class="slider-carousel owl-carousel owl-theme">
							<?php foreach($slider as $row){ ?>
                                <div class="slider-item">
                                    <img src="<?=$row->image ?>">
                                    <div class="slider-desc">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10 col-md-11 col-sm-12 col-12">
                                                <h2><?=$row->_title ?></h2>
                                                <p><?= yii\helpers\StringHelper::truncateWords(strip_tags($row->_text),40); ?></p>
                                                <div class="text-center">
                                                    <a href="<?= $row->url ?>" class="btn btn-light custom-btn"><?=yii::t('app','Subscription Sign Up') ?></a>
                                                    <a href="#" class="btn btn-light white-border-btn"><?=yii::t('app','More Information') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>
                            </div>
                        </section>
                        <!-- End Slider -->
                    </div>
                </div>  
            </div>
        </section>
        <!-- End Login Section -->
    </div>
    <!-- End Content -->

