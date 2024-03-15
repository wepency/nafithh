 <?php 
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
$this->title = yii::t('app','New Signup');
 $EOS = yii::$app->SiteSetting->queryEOS();
 use yii\helpers\ArrayHelper;
 use yii\helpers\Html;
use kartik\select2\Select2;

 ?>
<style type="text/css">
    .block-title hr {
        border-top: 5px solid #ca8b3c;
        width: 50px;
        float: right;
        margin-top: .2rem;
    }
    input[type="checkbox"], input[type="radio"] {
        background-color: #c6a53e !important;
        margin-inline-start: 34px;
        margin-inline-end: 12px;
        margin-top: 6px;
    }
    .input-group-text{
        background-color: #c6a53e !important;
        color: white;

    }
    #addFile,.inputfile {
        cursor: pointer;
    }
</style>
 <!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Contact Section -->
        <section class="contact-sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="title mb-5">
                            <h4>
                                <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                                <?= yii::t('app','New Signup') ?>
                            </h4>
                        </div>
						<div class="col-lg-14">
							<?php  Pjax::begin([]) ;?>
									 
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
                         <?php $form = ActiveForm::begin(['id' => 'contact-form','options'=>['enctype' => 'multipart/form-data','class'=>"form-horizontal"],'class'=>'contact-frm']); ?>
					
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Name') ?></label> 
										<?= $form->field($model, 'name')->textInput(['placeholder' => yii::t('app','Name')])->label(false) ?>
                               
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Email') ?></label>
                                        <?= $form->field($model, 'email')->textInput(['placeholder' => yii::t('app','Email')])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                         <label><?= yii::t('app','Mobile') ?></label>
                                        <?= $form->field($model, 'mobile')->textInput(['placeholder' => yii::t('app','Mobile')])->label(false) ?>
                      
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                         <label><?= yii::t('app','Identity Id') ?></label>
                                        <?= $form->field($model, 'identity_id')->textInput(['placeholder' => yii::t('app','Identity Id')])->label(false) ?>
                      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Password') ?></label>
                                          <?= $form->field($model, 'password')->textInput(['type'=> 'password','placeholder' => yii::t('app','Password')])->label(false) ?>
                      
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Confirm Password') ?></label>
                                          <?= $form->field($model, 'newPasswordConfirm')->textInput(['type'=> 'password','placeholder' => yii::t('app','Confirm Password')])->label(false) ?>
                      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-12"> -->
                                    <div class="form-group">
                                         <div class="block-title clearfix">
                                            <h5><?=Yii::t('app', 'User Type')?></h5>
                                            <hr>
                                        </div>
                                          <?= $form->field($model, 'user_type')->radioList(
                                            array_diff_key( yii::$app->params['userType'][Yii::$app->language],array_flip(['developer','admin','admin_user','estate_officer_user','maintenance_officer_user','owner','renter']) ),
                                            ['prompt'=> yii::t('app','Select User Type'),
                                            'class'=>'form-inline',
                                             'onchange'=>"
                                                value = $(this).find(':checked').val();
                                                div = $('.companyName');
                                                if(value == 'maintenance_officer' || value == 'estate_officer'){
                                                   div.show(); 
                                                }else{
                                                    div.hide(); 
                                                }
                                               ",
                                            ]
                                            )->label(false); ?>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <div class="row " >
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 companyName" style="display:none">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Office Name') ?></label>
                                          <?= $form->field($model, 'compony_name')->textInput(['placeholder' => yii::t('app','Office Name')])->label(false) ?>
                      
                                    </div>
                                </div>
<!--                                <div class="col-md-6 col-12" style="overflow: hidden">-->
<!--                                    <div class="form-group mb-25">-->
<!--                                        <label>--><?php //=Yii::t('app','Attach Documents');?><!--</label>-->
<!--                                        <div class="input-group " id="addFile" onclick="document.getElementById('signupform-imagefiles').click()">-->
<!--                                            <input type="text"  class="inputfile bg-white form-control" placeholder="--><?php //=Yii::t('app','Attach Documents')?><!--" readonly />-->
<!--                                            <div class="input-group-prepend">-->
<!--                                                <div class="input-group-text">-->
<!--                                                    <i class="fas fa-cloud-upload-alt"></i>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <span id="fp"></span>-->
<!---->
<!--                                        --><?php //= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true,'class' => 'position-absolute','style' => "right: -90px;bottom:-50px",
//                                            'onchange'=>'
//                                            fi = event.target;
//                                            if (fi.files.length > 0) {
//                                                // THE TOTAL FILE COUNT.
//                                                document.getElementById("fp").innerHTML =
//                                                    "Total Files: <b>" + fi.files.length + "</b></br >";
//                                            }
//                                            '
//                                        ])->label(false); ?>
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                    <button class="btn btn-light custom-btn"><?= yii::t('app','Subscribe') ?></button>
									
                                </div>
                            </div>
                       <?php ActiveForm::end(); ?>
					     <?php Pjax::end() ;?>
                    </div>
                </div>  
            </div>
        </section>
        <!-- End Contact Section -->
    </div>
    <!-- End Content -->
