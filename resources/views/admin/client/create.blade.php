@extends('admin.app')

@section('contentCSS')

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Client Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Client Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Registro de Cliente</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
        <form action="{{ route('client.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Nombre" required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Buscar Direccion</label>
                <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Enter Direccion" required>
                <button type="button" class="btn btn-secondary" id="btnSearchMaps">Buscar</button>
            </div>

            <div id="map_canvas" style="width:450px; height:450px;"></div>

            <div class="form-group">
                <label for="exampleInputEmail1">Latitud</label>
                <input type="text" class="form-control" id="location_lat" name="location_lat" readonly required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Longitud</label>
                <input type="text" class="form-control" id="location_lng" name="location_lng" readonly required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Estado</label>
                <select class="form-control" name="status" id="status">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="{{route('client.index')}}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

 

@endsection

@section('contentJS')

    <script type="text/javascript">var centreGot = false;</script>
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

            // const inputText = document.createElement("input");

            // inputText.type = "text";
            // inputText.placeholder = "Enter a location";

            // const submitButton = document.createElement("input");

            // submitButton.type = "button";
            // submitButton.value = "Geocode";
            // submitButton.classList.add("button", "button-primary");

            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);

            map.addListener("click", (e) => {
                geocode({ location: e.latLng });
            });

            // submitButton.addEventListener("click", () =>
            //     geocode({ address: inputText.value }),
            // );
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
            //var response_maps = JSON.stringify(result, null, 2);
            var response_maps = JSON.stringify(result["results"][0]["geometry"]["location"], null, 2);
            var json = JSON.parse(response_maps);
            // console.log(json["lat"])
            // console.log(json["lng"])
            // console.log(result["results"][0]["formatted_address"]);
            
            $("#street_address").val(result["results"][0]["formatted_address"]);
            $("#location_lat").val(json["lat"]);
            $("#location_lng").val(json["lng"]);
            
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

        $("#btnSearchMaps").click(function(){
            const inputText = document.getElementById("street_address");
            console.log(inputText.value)
            geocode({ address: inputText.value })
        });

    </script> 

@endsection