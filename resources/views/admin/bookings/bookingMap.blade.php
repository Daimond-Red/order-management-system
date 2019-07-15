<div id="map" style="width: 100%; height: 100%;"></div>

<script>

    function initMap() {

        locations = [];

        <?php if( isset($data) ): ?>
        locations = <?php echo json_encode($data);?>;
        <?php endif; ?>


        if( locations.length ) {
            var uluru = {lat: locations[0]['lat'], lng: locations[0]['lng']};
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: uluru
        });

        console.log(uluru);

        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        

        for (j = 0; j < locations.length; j++) {

            if(j == 0 || j == (locations.length - 1)) {
                var iconImg =  (j !==0 ) ?'http://maps.google.com/mapfiles/ms/icons/green-dot.png' :'{{ getImageUrl('img/location.png')}}';
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[j]['lat'], locations[j]['lng']),
                    map: map,
                    icon: iconImg
                });
            } else {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[j]['lat'], locations[j]['lng']),
                    map: map,
                    icon: '{{ getImageUrl('img/pin.png')}}'
                });
            }  

            google.maps.event.addListener(marker, 'click', (function(marker, i,j) {

                return function() {
                    infowindow.open(map, marker);
                }

            })(marker, i,j));

        }

        // var flightPlanCoordinates = [];

        // for (var i = 0; i < (locations.length-1); i++) {
        //     flightPlanCoordinates.push({ 'lat': locations[i]['lat'], 'lng': locations[i]['lng'] });
        // }

        // var flightPath = new google.maps.Polyline({
        //     path: flightPlanCoordinates,
        //     geodesic: true,
        //     strokeColor: '#EA4335',
        //     strokeOpacity: 1.0,
        //     strokeWeight: 2
        // });

        // flightPath.setMap(map);
    }

</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbTCice7lQbAjf1seeB-eMwwiVLjyE-DA&callback=initMap">
</script>
