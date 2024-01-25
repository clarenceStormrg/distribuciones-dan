<html><head>
    <script type="text/javascript">
        var centreGot = false;</script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key={{env('GOOGLE_MAPS_API_KEY')}}&"></script> 
    <script type="text/javascript"> //<![CDATA[ 
        var map; // Global declaration of the map 
        var lat_longs_map = new Array(); 
        var markers_map = new Array(); 
        var iw_map; iw_map = new google.maps.InfoWindow({}); 
        let marker_0;
        function initialize_map() { 
            var myOptions = { zoom: 13, mapTypeId: google.maps.MapTypeId.ROADMAP};
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); // Try W3C Geolocation (Preferred) 
            if(navigator.geolocation) { 
                navigator.geolocation.getCurrentPosition(
                    function(position) { 
                        map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude)); 
                    }, 
                    function() { 
                        //alert("Unable to get your current position. Please try again. Geolocation service failed."); 
                    }); // Browser doesn't support Geolocation 
            }else{ 
                alert('Your browser does not support geolocation.'); 
            } 
            google.maps.event.addListener(map, "bounds_changed", 
                function(event) { 
                    if (!centreGot) { 
                        var mapCentre = map.getCenter(); 
                        marker_0.setOptions({ position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) }); } 
                        centreGot = true; }); 
            var markerOptions = { map: map }; 
            marker_0 = createMarker_map(markerOptions); 

            geocoder = new google.maps.Geocoder();

            const inputText = document.createElement("input");

            inputText.type = "text";
            inputText.placeholder = "Enter a location";

            const submitButton = document.createElement("input");

            submitButton.type = "button";
            submitButton.value = "Geocode";
            submitButton.classList.add("button", "button-primary");

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);

            map.addListener("click", (e) => {
                geocode({ location: e.latLng });
            });

            submitButton.addEventListener("click", () =>
                geocode({ address: inputText.value }),
            );
            // marker = new google.maps.Marker({
            //     map,
            // });
            clear();
        }

        function geocode(request) {
            clear();
            geocoder
            .geocode(request)
            .then((result) => {
            const { results } = result;

            map.setCenter(results[0].geometry.location);
            marker_0.setPosition(results[0].geometry.location);
            marker_0.setMap(map);
            //responseDiv.style.display = "block";
            //response.innerText = JSON.stringify(result, null, 2);
            console.log(JSON.stringify(result, null, 2))
            return results;
            })
            .catch((e) => {
            alert("Geocode was not successful for the following reason: " + e);
            });
        }

        function clear() {
            marker_0.setMap(null);
            //responseDiv.style.display = "none";
        } 
        function createMarker_map(markerOptions) { 
            var marker = new google.maps.Marker(markerOptions); 
            markers_map.push(marker); 
            lat_longs_map.push(marker.getPosition()); 
            return marker; 
        } 
        google.maps.event.addDomListener(window, "load", initialize_map); //]]> 
    </script> 
    </head>
    <body>
    <div id="map_canvas" style="width:100%; height:450px;"></div>
    <p style="padding-top: 25px;font-weight: bold;">        
        {{env('MSG_MAPS')}}
    </p>
    </body></html>

