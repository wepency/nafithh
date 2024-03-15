<?php

use common\models\BuildingType;
use common\models\City;
use common\models\District;
use common\models\EstateOffice;
use common\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Nafithh gallery');
Yii::$app->assetManager->bundles = [
    'yii\bootstrap\BootstrapAsset' => false,
];

// echo "<pre>";
// print_r(count($gallery)); die();


$adSubType = Yii::$app->request->get('ad_subtype', 'بيع');
$styleView = Yii::$app->request->get('style_view', 'gride');
$listOffice = ArrayHelper::map(
    EstateOffice::find()->where(['>', 'estate_office.id', 0])->joinWith(['admin'], false)
        ->andWhere(['estate_office.status_account' => User::STATUS_ACTIVE])
        ->onCondition(['or', ['user.user_type' => 'estate_officer'], ['user.estate_officer' => 1]])->all()
    , 'admin_id', 'name');

?>
<?= Yii::$app->view->renderFile('@frontend/views/site/include/loading.php') ?>

    <style>
        .select2-container--krajee-bs3 .select2-selection--single, .select2-container--krajee-bs3 .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }
    </style>
    <!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Gallary Section -->
        <section class="gallary-sec">
            <div class="container-fluid">
                <div class="search-baner">
                    <div class="container">
                        <div class="search-block">
                            <?php /*
                        <div class="row" style="place-content: center;">
                            <div class="col-md-6">
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
                            </div>
                        </div>
                        */ ?>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $adSubType == 'بيع' ? 'active' : '' ?>"
                                            id="pills-home-tab" data-toggle="pill" data-target="#pills-home"
                                            type="button" role="tab" value='بيع' aria-controls="pills-home"
                                            aria-selected="true"><?= Yii::$app->params['adsubtype'][Yii::$app->language][1] ?></button>
                                </li>
<!--                                <li class="nav-item" role="presentation">-->
<!--                                    <button class="nav-link --><?php //= ($adSubType == 0) ? 'active' : '' ?><!--"-->
<!--                                            id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile"-->
<!--                                            type="button" role="tab" value='0' aria-controls="pills-profile"-->
<!--                                            aria-selected="false">--><?php //= Yii::$app->params['adsubtype'][Yii::$app->language][0] ?><!--</button>-->
<!--                                </li>-->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= ($adSubType == 'إيجار') ? 'active' : '' ?>"
                                            id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact"
                                            type="button" role="tab" value='إيجار' aria-controls="pills-contact"
                                            aria-selected="false"><?= Yii::$app->params['adsubtype'][Yii::$app->language][2] ?></button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="">
                                    <div class="search-frm">
                                        <div class="row">
                                            <?= Html::hiddenInput('ad_subtype', $adSubType, ['class' => 'estate_filter']) ?>
                                            <?= Html::hiddenInput('style_view', $styleView, ['class' => 'estate_filter']) ?>
                                            <div class="col-lg-10 col-md-9 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <?= Html::textInput('ad_description', Yii::$app->request->get('ad_description', ''), ['placeholder' => yii::t('app', 'Title Ads'), 'class' => 'form-control estate_filter'
                                                            ]) ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <?= Select2::widget([
                                                                'name' => 'estate_office_id',
                                                                'id' => 'estate_office_id',
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                ],
                                                                'value' => Yii::$app->request->get('office_id', ''),
                                                                'class' => 'form-control estate_filter',
                                                                'data' => $listOffice,
                                                                'options' => ['placeholder' => Yii::t('app', 'Estate Office Name'), 'prompt' => Yii::t('app', 'Estate Office Name'), 'class' => 'form-control estate_filter', 'style' => '    height: 42px;',]
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <?= Select2::widget([
                                                                'name' => 'building_type_id',
                                                                'id' => 'building_type_id',
                                                                'value' => Yii::$app->request->get('building_type_id', ''),
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                ],
                                                                'class' => 'form-control estate_filter',
                                                                'data' => ArrayHelper::map($buildingTypes, 'id', 'name'),
                                                                'options' => ['placeholder' => Yii::t('app', 'Type Of Estates'), 'prompt' => Yii::t('app', 'Type Of Estates'), 'class' => 'form-control estate_filter', 'style' => '    height: 42px;',]
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group form-group-with-icon">
                                                            <!-- <img src="<?= Yii::$app->homeUrl ?>images/location-pin.png"> -->
                                                            <?= Select2::widget([
                                                                'name' => 'city_id',
                                                                'id' => 'city_id',
                                                                'value' => Yii::$app->request->get('city_id', ''),
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                ],
                                                                'class' => 'form-control estate_filter',
                                                                'data' => ArrayHelper::map(City::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                                                                'options' => ['placeholder' => Yii::t('app', 'Select City'), 'prompt' => Yii::t('app', 'Select City'), 'class' => 'form-control estate_filter', 'style' => '    height: 42px;',]
                                                            ]); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group form-group-with-icon">
                                                            <!-- <img src="<?= Yii::$app->homeUrl ?>images/location-pin.png"> -->
                                                            <?= DepDrop::widget([
                                                                'name' => 'district_id',
                                                                'id' => 'district_id',
                                                                'data' => District::ListDistrictByCar(),
                                                                'type' => DepDrop::TYPE_SELECT2,
                                                                'options' => ['class' => 'estate_filter'],
                                                                'value' => Yii::$app->request->get('district_id', ''),
                                                                'select2Options' => [
                                                                    'pluginOptions' => [
                                                                        'multiple' => false,
                                                                        'allowClear' => true,
                                                                        'placeholder' => Yii::t('app', 'Select District'),
                                                                    ],
                                                                ],
                                                                'pluginOptions' => [
                                                                    'class' => 'form-control',
                                                                    'depends' => ["city_id"],
                                                                    'initialize' => true,
                                                                    'placeholder' => Yii::t('app', 'Select District'),
                                                                    'url' => Url::to(['/dropdown/district']),
                                                                    'loadingText' => Yii::t('app', 'Loading district ...'),
                                                                ],
                                                            ]); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group mobile-hide">
                                                            <button class="form-control" id="showPriceControls">
                                                                <?= yii::t('app', 'Price') ?>
                                                            </button>
                                                        </div>
                                                        <div class="mobile-show">
                                                            <div class="form-group">
                                                                <button class="form-control"
                                                                        id="showPriceControlsMobile">
                                                                    <?= yii::t('app', 'Price') ?>
                                                                </button>
                                                            </div>
                                                            <div class="priceInputs">
                                                                <div class="form-group">
                                                                    <?= Html::textInput('min_price', Yii::$app->request->get('min_price', ''), ['placeholder' => yii::t('app', 'Min Price'), 'class' => 'form-control estate_filter']) ?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?= Html::textInput('max_price', Yii::$app->request->get('max_price', ''), ['placeholder' => yii::t('app', 'Max Price'), 'class' => 'form-control estate_filter']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group mobile-hide">
                                                            <button class="form-control" id="showDisControls">
                                                                <?= yii::t('app', 'Space') ?>
                                                            </button>
                                                        </div>
                                                        <div class="mobile-show">
                                                            <div class="form-group">
                                                                <button class="form-control" id="showDisControlsMobile">
                                                                    <?= yii::t('app', 'Space') ?>
                                                                </button>
                                                            </div>
                                                            <div class="disInputs">
                                                                <div class="form-group">
                                                                    <?= Html::textInput('min_space', Yii::$app->request->get('min_space', ''), ['placeholder' => yii::t('app', 'Min Space'), 'class' => 'form-control estate_filter']) ?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?= Html::textInput('max_space', Yii::$app->request->get('max_space', ''), ['placeholder' => yii::t('app', 'Max Space'), 'class' => 'form-control estate_filter']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-12 col-12 d-flex justify-content-center align-self-center">
                                                <button type="button" id="search"
                                                        class="btn btn-light custom-btn"><?= yii::t('app', 'Search') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="prices">
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 form-input-bg priceInputs" id="">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                                                    <div class="form-group">
                                                        <?= Html::textInput('min_price', Yii::$app->request->get('min_price', ''), ['placeholder' => yii::t('app', 'Min Price'), 'class' => 'form-control estate_filter']) ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center pr-0">
                                                    <div class="form-group">
                                                        <?= Html::textInput('max_price', Yii::$app->request->get('max_price', ''), ['placeholder' => yii::t('app', 'Max Price'), 'class' => 'form-control estate_filter']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 form-input-bg disInputs" id="">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                                                    <div class="form-group">
                                                        <?= Html::textInput('min_space', Yii::$app->request->get('min_space', ''), ['placeholder' => yii::t('app', 'Min Space'), 'class' => 'form-control estate_filter']) ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center pr-0">
                                                    <div class="form-group">
                                                        <?= Html::textInput('max_space', Yii::$app->request->get('max_space', ''), ['placeholder' => yii::t('app', 'Max Space'), 'class' => 'form-control estate_filter']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div> -->
                                <!-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-result">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex align-self-center">
                                <p class="mb-0">
                                    <?= yii::t('app', 'Found') ?> <span
                                            class="search-no">0 </span><?= yii::t('app', 'Estates') ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-end align-self-center center-align">
                                <span class="ml-2"><?= yii::t('app', 'View Type') ?> </span>
                                <div class="grid-icon mx-2 <?= ($styleView !== 'list') ? 'active-list' : '' ?>"
                                     id="show-grid">
                                    <img src="<?= Yii::$app->homeUrl ?>images/visualization.png" class="gray-ico">
                                    <img src="<?= Yii::$app->homeUrl ?>images/visualization-active.png"
                                         class="active-ico">
                                </div>
                                <div class="list-icon <?= ($styleView == 'list') ? 'active-list' : '' ?> ">
                                    <img src="<?= Yii::$app->homeUrl ?>images/list-text.png" class="gray-ico"
                                         id="show-list">
                                    <img src="<?= Yii::$app->homeUrl ?>images/list-text-active.png" class="active-ico">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container ">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="slider-add mb-4 mt-4" id="sliderAdd">
                            <div class="slider-add-carousel owl-carousel owl-theme">
                                <!--                            --><?php //foreach($ads as $row){ ?>
                                <!--                                <div class="slider-add-item">-->
                                <!--                                    <a -->
                                <?php //= $row->link ? 'href="'.$row->link.'"':"" ?><!-- target="_blank">-->
                                <!--                                        <img src="-->
                                <?php //= $row->image ?><!--">-->
                                <!--                                    </a>-->
                                <!--                                </div>-->
                                <!--                            --><?php //} ?>
                                <?php /*
                                <div class="slider-add-item">
                                    <img src="images/pic-baneer.png">
                                    <div class="baner-desc">
                                        <h4>نافذة احدث منصة متطورة للوساطة العقارية</h4>
                                    </div>
                                </div>
                             */ ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gallary-div pt-50 loader" id="pjax_result">
                    <?= $this->render('_list', ['gallery' => $ads, 'pages' => $pages]); ?>
                </div>
            </div>
        </section>
        <!-- End Gallary Section -->
    </div>
    <!-- End Content -->
<?php

$url = Url::toRoute('/gallery/index');
$script = <<< JS
    filterSearch = function(){
        dataForm = $(".estate_filter").serialize();
        $.ajax({
            url: "$url",
            type: 'get',
            //dataType: 'json',
            data: dataForm
        })
        .done(function(data) {
            $('#pjax_result').html(data);
        })
        .fail(function() {
            console.log("error");
        });
    };
    $(".estate_filter").on('change keyup',function(event) {
        filterSearch();
    });
    $('#search').on('click', function () {
        filterSearch();
    });
JS;
$this->registerJs($script);
?>