<?php

use yii\helpers\StringHelper;

$mapList = \common\components\GeneralHelpers::getMaplist();
$setting = yii::$app->SiteSetting->info();

$settingMap = $mapList['settingMap'];
$projectMap = $mapList['projectMap'];



?>

 	<!-- Start Map -->
    <section class="map-sec">
        <div class="container-fluid text-center">
            <div class="row">
                <div id="map" class="full-width-map"></div>
            </div>      
        </div>
    </section>
    <!-- End Map -->

<script  src="https://maps.googleapis.com/maps/api/js?key=<?=$setting->key_google_map?>"  type="text/javascript"></script>

  <script type="text/javascript">

    <?php if(empty($model->lat)){
      $x = 15.344013285782536;
      $y = 44.19102388880924;
    }else
    {
      $x = $settingMap->lat;
      $y = $settingMap->lng;
    }?>
    <?php  if (!$projectMap) { ?>
        function initMap() {
          var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: <?=$x?>,
                    lng: <?=$y?>
                },
                zoom: 6
            });


            <?php $ii=1; foreach ($projectMap as $row) {?>

                var contentString = '<div id="content">'+
                    '<a href="<?=Yii::$app->homeUrl.'project/'.$row->id?>">'+
                    '<div class="img">'+
                    '<img src="<?=$row->image?>">'+
                    '</div>' +
                    '<div class="content-desc"> '+
                    '<h5><?=$row->_title?></h5> '+
                    '</a>'+
                    '<p><?=yii::t('app','Place Execution').' : '.$row->_place_execution?></p>'+
                    '<p><?=yii::t('app','Project Period').' : '.$row->_project_period?></p>'+
                    '<p><?=yii::t('app','Male Beneficiaries').' : '.$row->male_beneficiaries?></p>'+
                    '<p><?=yii::t('app','Female Beneficiaries').' : '.$row->female_beneficiaries?></p>'+
                    '</div>'+
                    '</div>';

                var infowindow<?=$ii?> = new google.maps.InfoWindow({
                      content: contentString
                    });
                
                
                var marker<?=$ii?> = new google.maps.Marker({
                    position: {
                        lat: <?=$row->lat?>,
                        lng: <?=$row->lang?>
                    },
                    map: map,
                    title: "",
                });
                
            
            marker<?=$ii?>.addListener('click', function() {
              infowindow<?=$ii?>.open(map, marker<?=$ii?>);
            });

            <?php  $ii++; } ?>
        }

    <?php } ?>

    </script>

