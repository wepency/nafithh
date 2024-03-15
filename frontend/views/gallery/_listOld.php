<?php
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\City;
use common\models\BuildingType;
use common\models\BuildingHousingUnit;

$adSubType = Yii::$app->request->get('ad_subtype',1);
$styleView = Yii::$app->request->get('style_view','gride');

 ?>
 <?php if(count((array) $gallery) == 0 ){ ?>
     <section class="sec-resnews container tm-container-content" style="    position: relative;min-height: 200px;">
        <!-- <hr class="hr-work-comp"> -->
        <div style="margin-top: 150px;">
        <p class="text-uppercase text-center mb-9 font-weight-bolder"><?=Yii::t('app','Sorry, there are no results matching your search!');?></p>
    </div>
    </section>
<?php } ?>
<?php  Pjax::begin([]) ;?>
    
        <div class="row" id="grid-view" style="<?=($styleView == 'list') ? 'display: none;' :''?>">

            <?php foreach($gallery as $row){ ?>
            <?php
                $isHousing = ($row->type == 'housing');
                if($isHousing){
                    $housing = BuildingHousingUnit::findOne($row->id);
                    $building_data =$housing->building;

                    $attachments = $housing->attachments;
                    $url = Yii::$app->homeURL.'gallery/housing/'.$row->id.'?type='.$adSubType;

                }else{
                    $building_data =$row;

                    $attachments = $row->attachments;
                    $url = Yii::$app->homeURL.'gallery/'.$row->id.'?type='.$adSubType;

                }

                $city = ($building_data->city->_name?? '').' - '.($building_data->district->_name?? '');
                $age = ($building_data->building_age >0)? $building_data->building_age : yii::t('app','New');
                $map = "https://maps.google.com/maps?q=".$building_data->lat.','.$building_data->lang;
                $estate_name = $building_data->estateContract->estateOffice->name?? '';
            ?>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12" style="margin-bottom:30px;">
                <div class="gallary-block" style=" height: 100%;">
                    <div class="gallary-img">
                        <a href="<?=$url?>">
                            <?php if(!empty($attachments)){
                                foreach($attachments as $image){ ?>
                                <img src="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>">
                                <?php break; }
                            }else{ ?>
                                <img src="<?=Yii::$app->homeUrl?>images/default.png">
                            <?php } ?>

                            <?php if($adSubType == 0){
                                $price= $row->invest_price; ?>
                                <span class="badge badge-primary green-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$adSubType]?></span>
                            <?php }elseif($adSubType == 2){
                                $price= $row->rent_price;
                            ?>
                                <span class="badge badge-primary green-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$adSubType]?></span>
                            <?php }else{
                                $price= $row->sale_price;
                            ?>
                                <span class="badge badge-primary red-bage"><?=Yii::$app->params['adsubtype'][Yii::$app->language][$adSubType]?></span>
                            <?php } ?>
                            <?php /*
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> <?=$row->date()?></small>
                            */ ?>
                            <?php if($row->ad_publish_date){ ?>
                                <span class="add-time">
                                    <img src="<?=Yii::$app->homeUrl?>images/clock-five.svg"><?=$row->date()?>
                                </span>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="gallary-disc">
                        <a href="<?=$url?>">
                            <h5><?= $row->ad_description ?></h5>
                        </a>
                        <p>
                            <a href="<?= $map ?>" target="_blank">
                                <img src="<?=Yii::$app->homeUrl?>images/icon-location.png">
                            </a>
                            <span><?= $city ?> </span>
                        </p>
                        <p class="small"><?= $estate_name ?></p>
                        <div class="building-data">
                           <span>
                                <img src="<?=Yii::$app->homeUrl?>images/plans.png" title="<?=yii::t('app','Space'); ?>"><?= $row->space ?>
                            </span>
                            <span>
                                <img src="<?=Yii::$app->homeUrl?>images/hotel.png" title="<?=yii::t('app','Number of Rooms'); ?>"> <?= $row->number_of_rooms ?>
                            </span>
                            <span>
                                <img src="<?=Yii::$app->homeUrl?>images/buildings.png" title="<?=yii::t('app','Building Age'); ?>"> <?= $age  ?>
                            </span>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="gallary-footer">
                            <span><?= number_format($price) ?> SR</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
                <nav aria-label="...">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'options'=>['class'=>'pagination pagination-sm justify-content-end'],
                    'linkContainerOptions'=>['class'=>'page-item'],
                    'linkOptions'=>['class'=>'page-link'],
                    'maxButtonCount'=>5,
                    ])?>
                </nav>
            </div>
        </div>

<?php  Pjax::end([]) ;?>


<?php
$count = $pages->totalCount;
$script = <<< JS
    dataForm = $(".search-no").html($count);
JS;
$this->registerJs($script);
?>