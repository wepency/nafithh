
<?php
use yii\helpers\Html;

$installment = $model->installment;
$estateOffice = $installment->contract->estateOffice;
?>

    <!-- Start Content -->
    <div class="contract-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="block-title clearfix">
                        <h4><?=Yii::t('app', 'Office information')?></h4>
                        <hr>
                    </div>
                    <div class="contract-block">
                        <div class="form-group">
                            <label><?=Yii::t('app', 'Office Name')?></label>
                            <span><?=$estateOffice->name?></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Registration Code')?></label>
                                    <span><?=$estateOffice->registration_code?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Email')?></label>
                                    <span><?=$estateOffice->email?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Mobile Number')?></label>
                                    <span><?=$estateOffice->mobile?></span>
                                </div>
                            </div>
                            <?php if (!is_null($estateOffice?->city)): ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Office Address')?></label>
                                    <span><?=$estateOffice?->city?->_name.' - '.$estateOffice?->district?->_name?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="block-title clearfix">
                        <h4><?=Yii::t('app', 'Receipt Catches Details')?></h4>
                        <hr>
                    </div>
                    <div class="contract-block">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Contract No')?></label>
                                    <span><?=$installment->contract->contract_no?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                     <label><?=Yii::t('app', 'Ejar Contract No')?></label>
                                    <span><?=$installment->contract->contract_no_ejar?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Installment No')?></label>
                                    <span><?=$installment->id?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Installment Number From Contract')?></label>
                                    <span><?=$installment->installment_no?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Installment Start Date')?></label>
                                    <span><?=$installment->start_date?></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Installment End Date')?></label>
                                    <span><?=$installment->end_date?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?=Yii::t('app', 'Renter Name')?></label>
                            <span><?=$installment->renter->name?></span>
                        </div>
                        <div class="form-group">
                            <label><?=Yii::t('app', 'Installment amount in Number')?></label>
                            <span><?=$installment->amount?></span>
                        </div>
                        <div class="form-group">
                            <label><?=Yii::t('app', 'Installment amount in letters')?></label>
                            <span><?=$installment->amount_text?></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Received amount')?></label>
                                    <span><?=$model->amount_paid?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Remaining amount')?></label>
                                    <span><?=$installment->amount_remaining?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Payment status of the Installment')?></label>
                                    <span><?=Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status]?></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?=Yii::t('app', 'Payment Method')?></label>
                                    <span><?=Yii::$app->params['PayMethod'][Yii::$app->language][$model->payment_method]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-block">
                            <label><?=Yii::t('app', 'Other Details')?></label>
                            <span><?=$installment->details?></span>
                        </div>
                        <div class="form-group d-block">
                            <label><?=Yii::t('app', 'Received by user')?></label>
                            <span><?=$model->userReceive->name?></span>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <!-- End Content -->
