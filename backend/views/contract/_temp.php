<?php

$building = $model?->building;
$housing = $model?->housingUnit;
$renter = $model?->renter;
$owner = $model?->owner;
$contract = $model;
$estateOffice = $model?->estateOffice;
?>

<!-- Start Content -->
<div class="contract-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="block-title clearfix">
                    <h5><?= Yii::t('app', 'Created Date ') ?> :
                        <span><?= Yii::$app->formatter->asDate($model?->created_date, 'php:Y/m/d'); ?></span></h5>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Office information') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="form-group">
                        <label><?= Yii::t('app', 'Office Name') ?></label>
                        <span><?= $estateOffice?->name ?></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Registration Code') ?></label>
                                <span><?= $estateOffice?->registration_code ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Email') ?></label>
                                <span><?= $estateOffice?->email ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Mobile Number') ?></label>
                                <span><?= $estateOffice?->mobile ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= Yii::t('app', 'Office Address') ?></label>
                        <span><?= $estateOffice?->city?->_name ?? '' . ' - ' . $estateOffice?->district?->_name ?? '' ?></span>
                    </div>
                </div>
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Owner Information') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Name') ?></label>
                                <span><?= $owner?->name ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Mobile') ?></label>
                                <span><?= $owner?->mobile ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Building Information') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Instrument Number') ?></label>
                                <span><?= $building?->instrument_number ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Building Name') ?></label>
                                <span><?= $building?->building_name ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Building ID') ?></label>
                                <span><?= $building?->id ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Water Account Number') ?></label>
                                <span><?= $building?->water_meter_no ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="block-title clearfix">
                        <h4><?= Yii::t('app', 'Building Address') ?></h4>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'City') ?></label>
                                <span><?= $building?->city?->_name ?? '' ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'District') ?></label>
                                <span><?= $building?->district?->_name ?? '' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Housing Unit Information') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Housing Unit Name') ?></label>
                                <span><?= $housing?->housing_unit_name ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Floors No') ?></label>
                                <span><?= $housing?->floors_no ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Area') ?></label>
                                <span><?= $housing?->area ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Entrances') ?></label>
                                <span><?= $housing?->entrances ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Rooms') ?></label>
                                <span><?= $housing?->rooms ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Number Of Toilets') ?></label>
                                <span><?= $housing?->toilets ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Conditioner Num') ?></label>
                                <span><?= $housing?->conditioner_num ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Electricity Meter Number') ?></label>
                                <span><?= $housing?->electricity_meter_no ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Water Meter Serial') ?></label>
                                <span><?= $housing?->water_meter_no ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" disabled
                                       id="customCheck1" <?= ($housing?->kitchen) ? 'checked' : '' ?> >
                                <label class="custom-control-label"
                                       for="customCheck1"><?= Yii::t('app', 'There is') . ' ' . Yii::t('app', 'Kitchen') ?></label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" disabled
                                       id="customCheck2" <?= ($housing?->pool) ? 'checked' : '' ?>>
                                <label class="custom-control-label"
                                       for="customCheck2"><?= Yii::t('app', 'There is') . ' ' . Yii::t('app', 'Pool') ?></label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" disabled
                                       id="customCheck3" <?= ($housing?->has_parking) ? 'checked' : '' ?>>
                                <label class="custom-control-label"
                                       for="customCheck3"><?= Yii::t('app', 'Has Parking') ?></label>
                            </div>
                        </div>
                    </div>

                    <?php
                    $renterType = Yii::$app->params['renterType'][Yii::$app->language];
                    if (isset($renterType[$housing?->using_for])) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?= Yii::t('app', 'Using For') ?></label>
                                    <span><?= Yii::$app->params['renterType'][Yii::$app->language][$housing?->using_for] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group d-block">
                        <label><?= Yii::t('app', 'Furniture') ?></label>
                        <span><?= $housing?->furniture ?></span>
                    </div>
                    <div class="form-group d-block">
                        <label><?= Yii::t('app', 'Other Details') ?></label>
                        <span><?= $housing?->detail ?></span>
                    </div>
                </div>
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Renter Information') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Name') ?></label>
                                <span><?= $renter?->name ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Identity ID') ?></label>
                                <span><?= $renter?->identity_id ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Mobile') ?></label>
                                <span><?= $renter?->mobile ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Email') ?></label>
                                <span><?= $renter?->email ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Nationality') ?></label>
                                <span><?= $renter?->nationality?->_name ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-title clearfix">
                    <h4><?= Yii::t('app', 'Contract Details') ?></h4>
                    <hr>
                </div>
                <div class="contract-block">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Contract No') ?></label>
                                <span><?= $contract?->contract_no ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Ejar Contract No') ?></label>
                                <span><?= $contract?->contract_no_ejar ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Contract Period') ?></label>
                                <span><?= $contract?->rentPeriod?->_name ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'From Date') ?></label>
                                <span><?= $contract?->start_date ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                            <div class="form-group">
                                <label><?= Yii::t('app', 'To Date') ?></label>
                                <span><?= $contract->end_date ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= Yii::t('app', 'Contract amount in Number') ?></label>
                        <span><?= $contract->price ?></span>
                    </div>

                    <div class="form-group">
                        <label><?= Yii::t('app', 'Contract amount in letters') ?></label>
                        <span><?= $contract->price_text ?></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Added Tax') ?></label>
                                <span><?= $contract->added_tax ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Insurance Amount') ?></label>
                                <span><?= $contract->insurance_amount ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Include Electricity') ?></label>
                                <span><?= Yii::$app->params['yesNo'][Yii::$app->language][$contract->include_electricity] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Include Maintenance') ?></label>
                                <span><?= Yii::$app->params['yesNo'][Yii::$app->language][$contract->include_maintenance] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Include Water') ?></label>
                                <span><?= Yii::$app->params['yesNo'][Yii::$app->language][$contract->include_water] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Water Amount') ?></label>
                                <span><?= $contract->water_amount ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Water Meter Serial') ?></label>
                                <span><?= $model->water_meter_serial ?? '--' ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Water Account Number') ?></label>
                                <span><?= $model->water_account_number ?? '--' ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Meter Reading Number') ?></label>
                                <span><?= $model->meter_reading_number ?? '--' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Brokerage Type') ?></label>
                                <span><?= $contract->brokerage_type == 1 ? Yii::t('app', 'Percentage') : Yii::t('app', 'Fixed') ?></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Brokerage Value') ?></label>
                                <span><?= $contract->brokerage_value ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Marketing Fees Type') ?></label>
                                <span><?= $contract->marketing_fees_type == 1 ? Yii::t('app', 'Percentage') : Yii::t('app', 'Fixed') ?></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Fees amount') ?></label>
                                <span><?= $contract->marketing_fees ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Property Management Fees Type') ?></label>
                                <span><?= $contract->property_management_fees_type == 1 ? Yii::t('app', 'Percentage') : Yii::t('app', 'Fixed') ?></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Fees amount') ?></label>
                                <span><?= $contract->property_management_fees ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Number') . ' ' . Yii::t('app', 'Installements') ?></label>
                                <span><?= $contract->number_installments ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?= Yii::t('app', 'Housing Using Type') ?></label>
                                <span><?= $contract->housingUsingType->_name ?? '' ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group policy">
                        <label><?= Yii::t('app', 'Terms And Conditions Temp') ?></label>
                        <ul>
                            <?= $contract->terms_and_conditions ?>
                            <!-- <li><div class="no">1</div><span class="list-span"></span></li>
                            <li><div class="no">2</div><span class="list-span"></span></li>
                            <li><div class="no">3</div><span class="list-span"></span></li>
                            <li><div class="no">4</div><span class="list-span"></span></li>
                            <li><div class="no">5</div><span class="list-span"></span></li>
                            <li><div class="no">6</div><span class="list-span"></span></li>
                            <li><div class="no">7</div><span class="list-span"></span></li>
                            <li><div class="no">8</div><span class="list-span"></span></li> -->

                        </ul>
                    </div>
                    <div class="form-group">
                        <label><?= Yii::t('app', 'Other Details About Contract') ?></label>
                        <span><?= $contract->details ?></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Content -->

