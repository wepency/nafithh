<?php

// use yii\helpers\StringHelper;

$setting = yii::$app->SiteSetting->info();

$lat = $setting->lat;
$lng = $setting->lng;



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

   
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
          center: {
              lat: <?=$lat?>,
              lng: <?=$lng?>
          },
          zoom: 6
      });

      var marker = new google.maps.Marker({
          position: {
              lat: <?=$lat?>,
              lng: <?=$lng?>
          },
          map: map,
          title: "",
      });
  }

    
</script>

