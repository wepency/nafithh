<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->SiteSetting->siteName();
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\bootstrap\Modal;
Yii::$app->assetManager->bundles = [
    'yii\bootstrap\BootstrapAsset' => false,
];
CrudAsset::register($this);
// print_r($ads); die();
?>

    <!-- Start Content -->
    <div class="site-content padt-50">
        <!-- Start Login Section -->
        <section class="login-sec">
            <div class="container-fluid pl-0">
                <div class="row">
                    <div class="col-lg-5 offset-lg-1 col-md-12 col-sm-12 col-12 login-div">
                         <!-- new -->
                        <div class="slider-add mb-4" id="sliderAdd">
                            <div class="slider-add-carousel owl-carousel owl-theme">
                                <?php foreach($ads as $row){ ?>
                                    <div class="slider-add-item">
                                        <a <?= $row->link ? 'href="'.$row->link.'"':"" ?> target="_blank">
                                            <img src="<?= $row->image ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <?php
                        if (Yii::$app->user->isGuest && 5 == 7):
                            ?>
                            <!-- /new -->
                            <div class="login-frm-div">
                                <div class="title mb-4">
                                    <h4>
                                        <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                                        <?= yii::t('app','Login')?>
                                    </h4>
                                </div>
                                <?php $form = ActiveForm::begin([/*'action'=>['login'],*/
                                    'options' => ['method' => 'post','class'=>'form-group'],
                                ]); ?>
                                <div class="form-group">
                                    <label><?= yii::t('app','User Name')?></label>
                                    <?= $form->field($model, 'username')->textInput(['placeholder'=>Yii::t('app','User Name'),'class'=>'form-control'])->label(false) ?>

                                </div>
                                <div class="form-group">
                                    <label><?= yii::t('app','Passward')?></label>
                                    <?= $form->field($model, 'password')->textInput(['class'=>'form-control'])->label(false)->passwordInput() ?>
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
                                <?php Modal::begin([
                                    "id"=>"ajaxCrudModal",
                                    'options' =>[
                                        'style' => 'z-index:10000',
                                    ],
                                    "footer"=>"",// always need it for jquery plugin
                                ])?>
                                <?php Modal::end(); ?>
                                <?=Html::activeHiddenInput($model, "agreeTerm"); ?>
                                <div class="text-center mt-5">
                                    <?= Html::submitButton(yii::t('app','Login'), ['class' => 'btn btn-light custom-btn']) ?>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="small yellow-color text-center"> <a href="<?=Yii::$app->homeUrl?>site/signup"><?= yii::t('app','Create New Account')?></a></p>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                                <?php endif; ?>

                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 mp-0">
                        <!-- Start slider -->
                        <section class="slider" id="slider">
                            <div class="slider-carousel owl-carousel owl-theme">
							<?php foreach($slider as $row){ ?>
                                <div class="slider-item">
                                    <?php
                                    $ext = pathinfo($row->image, PATHINFO_EXTENSION);
                                     if($ext === 'mp4' || $ext === 'mkv'){ ?>
                                        <video id="myVideo-<?=$row->id?>" width="100%" height ="100%" controls>
                                            <source src="<?=$row->image?>" type="video/mp4">
                                        </video>
                                    <?php }else{ ?>
                                        <img src="<?=$row->image ?>">
                                        <div class="slider-desc">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10 col-md-11 col-sm-12 col-12">
                                                    <h2><?=$row->_title ?></h2>
                                                    <p><?= yii\helpers\StringHelper::truncateWords(strip_tags($row->_text),40); ?></p>
                                                    <div class="text-center">
                                                        <a href="<?=Yii::$app->homeUrl?>subscribe" class="btn btn-light custom-btn"><?=yii::t('app','Subscription Sign Up') ?></a>
                                                        <a href="<?= $row->url ?>" class="btn btn-light white-border-btn"><?=yii::t('app','More Information') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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

<?php 
$script = <<< JS
$(document).ready(function(){
     modal = new ModalRemote('#ajaxCrubModal');
});
JS;
$this->registerJs($script);
?>