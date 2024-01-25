@extends('admin.app')

@section('contentCSS')
  <!-- DataTables -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Page</li>
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
          <h3 class="card-title">Listado de Pedidos</h3>

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
          <table id="tableDT" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>OrderId</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Conductor</th>
                <th>Fecha Envio</th>
                <th>Productos</th>
                <th>Mapa</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($data as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cliente }}<br>{{$item->direccion}}</td>
                <td>{{ $item->vendedor }}</td>
                <td>{{ $item->conductor }}</td>
                <td>{{ $item->shipping_date }}</td>
                <td><a href="#" onclick="viewModalProduct(this)" data-id="{{$item->id}}" class="btn btn-success"><i class="fa fa-eye"></i></a></td>
                <td>                  
                  <a href="#" class="btn btn-primary" onclick="viewModalMaps(this)" data-id="{{$item->id}}" data-lng="{{$item->location_lng}}" data-lat="{{$item->location_lat}}" ><i class="fa fa-eye"></i></a>                  
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>OrderId</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Conductor</th>
                <th>Fecha Envio</th>
                <th>Estado</th>
                <th>Opciones</th>
              </tr>
            </tfoot>
          </table>
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

    <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mostrar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl-product" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMaps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mostrar Mapa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_canvas" style="width:100%; height:300px;"></div>
            </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="routeProduct" value="{{route('pickup.product')}}">
    <input type="hidden" id="routeMaps" value="{{route('pickup.maps')}}">
    <input type="hidden" id="lat_initial" value ="{{env('MAP_LAT')}}">
    <input type="hidden" id="lng_initial" value ="{{env('MAP_LNG')}}">

@endsection

@section('contentJS')
  <!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $('#tableDT').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function viewModalProduct(e){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: $("#routeProduct").val(),
        dataType: "JSON",
        data: {id:$(e).data("id")},
        success: function(respu){
            let htmlProduct = "";
            respu["data"].forEach((item,index) => 
            {
                htmlProduct += `<tr>
                                    <td>${index+1}</td>
                                    <td>${item.product}</td>
                                    <td>${item.quantity}</td>
                                </tr>`;
            });
            $("#tbl-product tbody").html(htmlProduct);
            $("#modalProduct").modal("show");
        },
        error: function(error)
        {
            console.log(error)
        }
    });
  }

</script>

<script type="text/javascript">var centreGot = false;</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key={{env('GOOGLE_MAPS_API_KEY')}}&"></script> 

<script type="text/javascript"> //<![CDATA[ 
    var map; // Global declaration of the map 
    var lat_longs_map = new Array(); 
    var markers_map = new Array(); 
    var iw_map; iw_map = new google.maps.InfoWindow({}); 
    let marker_0;
    let marker_1;
    let directionsService;
    let directionsRenderer;
    function initialize_map() { 
        var myOptions = { zoom: 13, mapTypeId: google.maps.MapTypeId.ROADMAP};
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); // Try W3C Geolocation (Preferred) 
        if(navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(
                function(position) { 
                    map.setCenter(new google.maps.LatLng($("#lat_initial").val(),$("#lng_initial").val())); 
                }, 
                function() { 
                    //alert("Unable to get your current position. Please try again. Geolocation service failed."); 
                }); // Browser doesn't support Geolocation 
        }else{ 
            alert('Your browser does not support geolocation.'); 
        } 
        // google.maps.event.addListener(map, "bounds_changed", 
        //     function(event) { 
        //         if (!centreGot) { 
        //             var mapCentre = map.getCenter(); 
        //             marker_0.setOptions({ position: new google.maps.LatLng($("#lat_initial").val(),$("#lng_initial").val()) }); } 
        //             centreGot = true; }); 
        // var markerOptions = { map: map }; 
        //marker_0 = createMarker_map(markerOptions); 

        //clear();
    }

    function clear() {
        if(marker_1 != null) marker_1.setMap(null);
        //responseDiv.style.display = "none";
    } 
    function createMarker_map(markerOptions) { 
        var marker = new google.maps.Marker(markerOptions); 
        markers_map.push(marker); 
        lat_longs_map.push(marker.getPosition()); 
        return marker; 
    } 
    google.maps.event.addDomListener(window, "load", initialize_map); //]]> 

    function viewModalMaps(e){
        //$(e).data("lng")
        //clear();

        // var myLatlng = new google.maps.LatLng($(e).data("lat"), $(e).data("lng"));
        // const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        // marker_1 = new google.maps.Marker({
        //   position: myLatlng,
        //   icon: image,
        // });
        // marker_1.setMap(map);

        if(directionsRenderer!=null) directionsRenderer.setMap(null);

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();

        directionsRenderer.setMap(map);            
        directionsService
          .route({
            origin: { lat: parseFloat($("#lat_initial").val()), lng: parseFloat($("#lng_initial").val()) },
            destination: { lat: parseFloat($(e).data("lat")), lng: parseFloat($(e).data("lng"))},
            // Note that Javascript allows us to access the constant
            // using square brackets and a string value as its
            // "property."
            travelMode: google.maps.TravelMode["DRIVING"],
          })
          .then((response) => {
            directionsRenderer.setDirections(response);
          })
          .catch((e) => window.alert("Directions request failed due to " + e));

        $("#modalMaps").modal("show");
    }

</script> 

@endsection