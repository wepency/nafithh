 <?php 
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
 ?>
 
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
                                <?= yii::t('app','Subscribe With Us') ?>
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
                         <?php $form = ActiveForm::begin(['id' => 'contact-form','class'=>'contact-frm']); ?>
					
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
                                        <label><?= yii::t('app','Company Type') ?></label>
										  <?= $form->field($model, 'compony_type')->dropDownList(
											Yii::$app->params['compony_type'][Yii::$app->language], 
											['prompt'=> yii::t('app','Select Company Type') ]
											)->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Company Name') ?></label>
                                          <?= $form->field($model, 'company_name')->textInput(['placeholder' => yii::t('app','Company Name')])->label(false) ?>
                      
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label><?= yii::t('app','Message') ?></label>
                                        <?= $form->field($model, 'message')->textarea(['placeholder' => yii::t('app','Message')])->label(false) ?>
                  
                                    </div>
                                </div>
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
