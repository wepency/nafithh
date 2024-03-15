<?php

// print_r(yii::$app->user->identity); 
// print_r($model->estateContract); 
// die();
// $this->registerJsFile("@web/js/jquery.fancybox.min.js");

$searchType = Yii::$app->request->get('type',0);
$this->title = Yii::t('app', 'Nafithh gallery').' - ' .$model->ad_description;

?>
<!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Gallary Section -->
        <section class="gallary-sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="title mb-4">
                            <h4>
                                <?= $model->ad_description?>
							<?php if($searchType == 0){
                                $price= $model->invest_price; ?>
                                <span class="badge badge-primary green-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$searchType]?></span>
                            <?php }elseif($searchType == 2){
                                $price= $model->rent_price;
                            ?>
                                <span class="badge badge-primary green-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$searchType]?></span>
                            <?php }else{
                                $price= $model->sale_price;
                            ?>
                                <span class="badge badge-primary red-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$searchType]?></span>
                            <?php } ?>
							</h4>
                            <p>
                          	<a href="https://maps.google.com/maps?q=<?= $model->lat ?>,<?= $model->lang ?>" target="_blank">     <i class="fas fa-map-marker-alt fa-2x"></i> </a>
                                <span><?= $model->city->_name?? '' ?> - <?= $model->district->_name?? '' ?> </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="gallary-preview-div mb-4">
                    <div class="row">
                        <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                            <div class="zoom-left">
							<?php
                                if(!empty($model->attachments)){
                                    foreach($model->attachments as $image){ ?>
                                    <img id="img_01" src="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>" data-zoom-image="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>" title="" alt="" class="zoom-img" />

                                    <?php break; }
                                }else{?>
                                    <img id="img_01" src="<?=Yii::$app->homeUrl?>images/default.png" data-zoom-image="<?=Yii::$app->homeUrl?>images/default.png" title="" alt="" class="zoom-img" />
                                <?php } ?>
                                <div id="gal1">
                                    <?php  if(!empty($model->attachments)){
                                        foreach($model->attachments as $image){
                                        ?>
                                        <a class="elevatezoom-gallery" data-update=""
                                            data-image="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>"
                                            data-zoom-image="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>"
                                            href="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>" data-fancybox="gallery" >
                                            <img id="img_01" src="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>" width="100"/>
                                        </a>
                                    <?php }}?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="info">
                                <div class="info-title">
                                    <span><?= yii::t('app','Estate Price') ?></span>
                                    <h4><?= number_format($price) ?> SR</h4>
                                </div>
                                <div class="owner-info">
                                    <h5><?= yii::t('app','Request an inquiry about the property') ?></h5>
                                    <!--<p class="small">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ</p> <!-->
                                    <div class="form-group">
                                        <label><?= yii::t('app','Estate Office Name') ?></label>
                                        <input type="text" name="" class="form-control font-weight-bold" disabled="" value="<?=$model->estateContract->estateOffice->name?? '' ?>">
                                    </div>
                                    <?php
                                    $mobile = $model->estateContract->estateOffice->mobile?? '' ;
                                    if($mobile){ ?>
                                        <div class="form-group">
                                            <label><?= yii::t('app','Estate Office mobile') ?></label>
                                            <input type="text" name="" class="form-control font-weight-bold" disabled="" value="<?=$mobile ?>">
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php if($mobile){ ?>
                                    <div class="contact-info-div mt-3">
                                        <a href="tel:+966<?=$mobile ?>">
                                            <div class="media contact-info-span">
                                                <img src="<?=Yii::$app->homeUrl?>images/icon-phonecall.png" class="ml-2" alt="...">
                                                <div class="media-body clearfix align-self-center">
                                                    <?=$mobile ?>
                                                </div>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://api.whatsapp.com/send?phone=+966<?=$mobile ?>">
                                            <div class="media contact-info-span float-left">
                                                <img src="<?=Yii::$app->homeUrl?>images/whatsapp.png" class="ml-2" alt="...">
                                                <div class="media-body clearfix align-self-center">
                                                    <?=$mobile ?>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="title mb-4 clearfix">
                                <h4>
                                    <?= yii::t('app','Estate Details') ?>
                                </h4>
                                <hr/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','City') ?></h5>
                                    <span class="mr-auto"><?=$model->city->_name ?? ''?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','District') ?></h5>
                                    <span class="mr-auto"><?=$model->district->_name ?? ''?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Street Name') ?></h5>
                                    <span class="mr-auto"><?=$model->street_name?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Real Estate Interface') ?></h5>
                                    <span class="mr-auto"><?=$model->real_estate_interface;?></span>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Street Width') ?></h5>
                                    <span class="mr-auto"><?=$model->street_view;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Limits and Lengths of the Property') ?></h5>
                                    <span style="width:150px;" class="mr-auto">
                                        <?= Yii::t('app', 'Width') ?> :
                                        <?=$model->width;?>
                                        <br>
                                        <?= Yii::t('app', 'Length') ?> :
                                        <?=$model->length;?>
                                    </span>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Space') ?></h5>
                                    <span class="mr-auto"><?=$model->space?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Number of Rooms') ?></h5>
                                    <span class="mr-auto"><?=$model->number_of_rooms?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Room Type') ?></h5>
                                    <span class="mr-auto"><?=$model->room_type;?></span>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Type Of Estates') ?></h5>
                                    <span class="mr-auto"><?=$model->buildingType->_name;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Building Age') ?></h5>
                                    <span class="mr-auto"><?=$model->building_age?></span>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Floors') ?></h5>
                                    <span class="mr-auto"><?=$model->floors?></span>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Housing Units') ?></h5>
                                    <span class="mr-auto"><?=$model->housing_units?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Furnished') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->furnished]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Air Condition') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->aircondition]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Availability of Elevators') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->availability_elevators]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Availability of Parking') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->availability_parking]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Kitchen') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->kitchen]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Is there a mortgage or restriction that prevents or limits the disposal or use of the property?') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->limit_property]?>
                                       </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Rights and obligations over real estate not documented in the real estate document') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->document_rights]?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Information that may affect the property') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][$model->information_affects]?></span>
                                </div>
                            </div>
                        </div>
                        <?php /*
						<div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Building Status') ?></h5>
                                    <span class="mr-auto"><?=Yii::$app->params['buildingStatus'][Yii::$app->language][$model->building_status]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="media building-info">
                                <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">
                                <div class="media-body clearfix align-self-center">
                                    <h5 class="mt-0"><?= yii::t('app','Neighborhood Name') ?></h5>
                                    <span class="mr-auto"><?=$model->neighborhood_name;?></span>
                                </div>
                            </div>
                        </div>
                        */


                        ?>

                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="title mb-1 clearfix">
                                <h4>
                                   <?= yii::t('app','Other Details') ?>
                                </h4>
                                <hr/>
                            </div>
                            <p class="text-justify">
                                <?= $model->description  ?>
                            </p>
                        </div>
                     <a href="javascript:history.back()" class="btn btn-light custom-btn"><?=yii::t('app','back') ?></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Gallary Section -->
    </div>
    <!-- End Content -->