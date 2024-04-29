<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="box-body table-responsive">

        <h5 class="text-muted"><?= Yii::t('app', 'Please make sure the address entered is accurate.') ?></h5>

        <div class="form-group">

            <input id="searchInput" class="form-control controls" name="Gallery[address]" type="text"
                   placeholder="يرجى إدخال عنوان العقار" required />

            <input id="lat" name="Gallery[lat]" type="hidden" required/>
            <input id="lng" name="Gallery[lng]" type="hidden" required/>

            <div id="googleMap" style="width:100%;height:400px;"></div>
        </div>
    </div>

    <div class="box-footer">
        <div class="form-group">
            <?= Html::button(\Yii::t('app', 'Next') . '<i class="glyphicon glyphicon-chevron-left"></i> ', [
                'class' => 'button button-primary mt-5 loadMainContent'
            ]) ?>
        </div>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg-ick3BgA97MfR3EDax7psToQ8lK77Dg&libraries=places"
            defer></script>
<script>
    let lat = <?= $model->lat ?? 21.4858 ?>,
        lng = <?= $model->lng ?? 39.1925 ?>
</script>

<?php

$script = <<< JS

let markers = [],
        map;

function isArabic(string) {
        let def = 0;
        let ar = 0;
        string.split('').forEach(i => /[\u0600-\u06FF]/.test(i) ? (ar++) : (def++))
        return ar >= def
    }

function myMap() {
        map = new google.maps.Map(document.getElementById('googleMap'), {
            center: {lat: lat, lng: lng},
            zoom: 10
        });

        var input = document.getElementById('searchInput');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        addMarker(lat, lng)

        map.addListener('click', function (mapsMouseEvent) {
            // alert('clicked')
            const latLng = mapsMouseEvent.latLng.toJSON();
            addMarker(latLng.lat, latLng.lng)
        })

        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            marker.setIcon(({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';

            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);

            // Location details
            // for (var i = 0; i < place.address_components.length; i++) {
            //     if (place.address_components[i].types[0] == 'postal_code') {
            //         document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
            //     }
            //     if (place.address_components[i].types[0] == 'country') {
            //         document.getElementById('country').innerHTML = place.address_components[i].long_name;
            //     }
            // }

            const loc = place.geometry.location;
            // document.getElementById('lat').innerHTML = loc.lat();
            // document.getElementById('lon').innerHTML = loc.lng();

            addMarker(loc.lat(), loc.lng())
        });
    }
    
    function getRegion(components) {
        let region = null;

        for (i = 0; i < components.length; i++) {
            if (isArabic(components[i].long_name) && typeof components[i].long_name !== "number")
                region = components[i].long_name;
        }

        console.log(components)
        return region;
    }
    
    let geocoder = new google.maps.Geocoder()
    
    function coordinates_to_address(lat, lng) {
        let latlng = new google.maps.LatLng(lat, lng);

        geocoder.geocode({'latLng': latlng}, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#searchInput').val(results[0].formatted_address);

                    // $('#region').val(results[0].address_components[1].long_name)
                    // $('#region').val([3].long_name)
                    
                    // Add old ad data here
                    $('#region').val(getRegion(results[0].address_components));

                } else {
                    alert('No results found');
                }
            } else {
                var error = {
                    'ZERO_RESULTS': 'Kunde inte hitta adress'
                }

                // alert('Geocoder failed due to: ' + status);
                $('#address_new').html('<span class="color-red">' + error[status] + '</span>');
            }
        });
    }
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;

        coordinates_to_address(lat, lng)
        myMap();
        addMarker(lat, lng)
    }
JS;

if (!$model->lat && !$model->lng) {
    $script .= <<<JS
        getLocation();
    JS;
}

$script .= <<<JS

    // Add marker
    function addMarker(lat, lon) {
        deleteMarkers();

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lon),
            map: map
        });

        markers.push(marker);
        coordinates_to_address(lat, lon)
        $('#lat').val(lat)
        $('#lng').val(lon)
        // map.setCenter(new google.maps.LatLng(lat, lon));
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);  //markerToBeRemoved.setMap(null);
        }
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }
    
    window.addEventListener('load', myMap)
    
JS;

$this->registerJs($script);

?>