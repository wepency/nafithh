<?php

// print_r(yii::$app->user->identity); 
// print_r($model->estateContract); 
// die();
// $this->registerJsFile("@web/js/jquery.fancybox.min.js");

$searchType = Yii::$app->request->get('type',0);
$this->title = Yii::t('app', 'Nafithh gallery').' - ' .$model->name;

?>

<style>
    span.icon{
        width: 80px;
        height: 80px;
        color: #ffffff;
        background-color: #c6a53e;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 25px;
    }
    .media.building-info {
        background-color: #f7f7f7;
        border-radius: 10px;
    }
</style>
<!-- Start Content -->
<div class="site-content pad-50">

    <!-- Start Gallary Section -->
    <section class="gallary-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="title mb-4">
                        <h4><?= $model?->name ?></h4>

                        <p>
                            <a href="https://maps.google.com/maps?q=<?= $model?->lat ?>,<?= $model?->lng ?>" target="_blank">     <i class="fas fa-map-marker-alt fa-2x"></i> </a>
                            <span><?= $model?->region ?> - <?= $model?->district ?> - <?= $model?->city ?></span>
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
                                <h4><?= number_format($model->propertyPrice) ?> SR</h4>
                            </div>

                            <div class="owner-info">
                                <h5><?= yii::t('app','Request an inquiry about the property') ?></h5>
                                <!--<p class="small">هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ</p> <!-->
                                <div class="form-group">
                                    <label><?= yii::t('app','Estate Office Name') ?></label>
                                    <input type="text" name="" class="form-control font-weight-bold" value="<?=$estateOfficer?->name ?? '' ?>" disabled />
                                </div>

                                <?php
                                $mobile = $model?->user?->mobile ?? '';

                                if($mobile){ ?>
                                    <div class="form-group">
                                        <label><?= yii::t('app','Estate Office mobile') ?></label>
                                        <input type="text" name="" class="form-control font-weight-bold" disabled="" value="<?= $mobile ?>">
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
                            <h4><?= yii::t('app','Estate Details') ?></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->
                            <span class="icon"><i class="fa fa-map"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','City') ?></h5>
                                <span class="mr-auto"><?=$model->city ?? ''?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-location-arrow"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','District') ?></h5>
                                <span class="mr-auto"><?=$model->district ?? ''?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-map-marker"></i></span>

                            <div class="media-body" style="flex-direction: column;align-items: baseline;">
                                <h5 class="m-0"><?= yii::t('app','address') ?></h5>
                                <span style="font-size: 80%;" class="mr-auto"><?=$model?->address?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->
                            <span class="icon"><i class="fa fa-building"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Real Estate Interface') ?></h5>
                                <span class="mr-auto"><?=$model?->propertyFace ?? 'لا يوجد'?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-road"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Street Width') ?></h5>
                                <span class="mr-auto"><?=$model?->streetWidth;?></span>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">--><?php //= yii::t('app','Limits and Lengths of the Property') ?><!--</h5>-->
<!--                                <span style="width:150px;" class="mr-auto">--><?php //= $model->borders ?><!--</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
                            <span class="icon"><i class="fas fa-arrows-alt"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Space') ?></h5>
                                <span class="mr-auto"><?=$model?->propertyArea?></span>
                            </div>
                        </div>
                    </div>

<!--                    --><?php //if ($model?->numberOfRooms): ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-th-large"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Number of Rooms') ?></h5>
                                <span class="mr-auto"><?=$model?->numberOfRooms?></span>
                            </div>
                        </div>
                    </div>
<!--                    --><?php //endif; ?>

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">--><?php //= yii::t('app','Room Type') ?><!--</h5>-->
<!--                                <span class="mr-auto">--><?php //=$model->propertyType;?><!--</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">نوع الغرف</h5>-->
<!--                                <span class="mr-auto">ديلوكس </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    -->

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-hospital"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Type Of Estates') ?></h5>
                                <span class="mr-auto"><?=$model->propertyType?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-calendar"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Building Age') ?></h5>
                                <span class="mr-auto"><?=$model->propertyAge?></span>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">عدد الأدوار</h5>-->
<!--                                <span class="mr-auto">4</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">عدد الوحدات</h5>-->
<!--                                <span class="mr-auto">14</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="--><?php //=Yii::$app->homeUrl?><!--images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon">
                                <i class="fas fa-briefcase"></i>
                            </span>

                            <div class="media-body d-flex flex-column align-items-start">
                                <h5 class="mt-0">خدمات العقار</h5>

                                <?php
                                    $utilities = unserialize($model->propertyUtilities);
                                    if (!empty($utilities)) {
                                        $utilities = implode(', ', $utilities);
                                    }
                                ?>

                                <p class='ml-auto'><?= $utilities ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->

                            <span class="icon"><i class="fa fa-tv"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0">مؤثث (مفروش)</h5>
                                <span class="mr-auto"><?= $model->furniture ? 'نعم' : 'لا' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
                            <span class="icon"><i class="fa fa-thermometer-empty"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0">التكييف</h5>
<!--                                <span class="mr-auto">--><?php //= $model->airConditioning ? 'نعم' : 'لا' ?><!--</span>-->
                                <span class="mr-auto">لا</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
                            <span class="icon"><i class="fa fa-angle-double-up"></i></span>

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0">توافر المصاعد</h5>
                                <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][!is_null($model?->elevator)]?></span>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">توافر المواقف</h5>-->
<!--                                <span class="mr-auto">نعم</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">المطبخ (خزائن المطبخ مركبة)</h5>-->
<!--                                <span class="mr-auto">لا</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
                            <img src="/images/icon1.png" class="ml-2" alt="...">
                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0">هل يوجد الرهن أو القيد الذي يمنع او يحد من التصرف او الانتفاع من العقار؟</h5>

                                <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][!is_null($model?->obligations)]?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="media building-info">
                            <img src="<?=Yii::$app->homeUrl?>images/icon1.png" class="ml-2" alt="...">

                            <div class="media-body clearfix align-self-center">
                                <h5 class="mt-0"><?= yii::t('app','Rights and obligations over real estate not documented in the real estate document') ?></h5>
                                <span class="mr-auto"><?=Yii::$app->params['yesNo'][Yii::$app->language][!is_null($model?->obligations)]?></span>
                            </div>
                        </div>
                    </div>

<!--                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">-->
<!--                        <div class="media building-info">-->
<!--                            <img src="/images/icon1.png" class="ml-2" alt="...">-->
<!--                            <div class="media-body clearfix align-self-center">-->
<!--                                <h5 class="mt-0">المعلومات التي قد تؤثر على العقار سواء في خفض قيمته او التأثير على قرار المستهدف بالإعلان</h5>-->
<!--                                <span class="mr-auto">لا</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

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
                            <?= $model?->description  ?>
                        </p>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-light custom-btn">رجوع</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Gallary Section -->
</div>
<!-- End Content -->