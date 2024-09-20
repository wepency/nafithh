<?php
$setting = yii::$app->SiteSetting->info();
$lat = ($lat) ? $lat : $setting->lat;
$lang = ($lang) ? $lang : $setting->lang;
?>
<style type="text/css">
  .container-fluid {
    width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;margin-top: 20px;text-align: -webkit-center;}
  .full-width-map {
    width: 80%;height: 300px;}
</style>
 	<!-- Start Map -->
        <div class="container-fluid text-center">
              <div id="map" class="full-width-map"></div>
        </div>
    <!-- End Map -->
  <script  src="https://maps.googleapis.com/maps/api/js?key=<?=$setting->key_google_map?>"  type="text/javascript"></script>

  <script type="text/javascript">
    var map = new google.maps.Map(document.getElementById('map'), {
          center: {
              lat: <?=$lat?>,
              lng: <?=$lang?>
          },
          zoom: 6
      });
      var marker = new google.maps.Marker({
          position: {
              lat: <?=$lat?>,
              lng: <?=$lang?>
          },
          map: map,
          title: "",
      });
</script>

