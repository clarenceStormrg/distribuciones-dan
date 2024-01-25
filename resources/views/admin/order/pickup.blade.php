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
          <h3 class="card-title">Tus Rutas</h3>

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
          
          <div id="map_canvas" style="width:100%; height:100vh"></div>
          <p style="padding-top: 25px;font-weight: bold;">        
              {{env('MSG_MAPS')}}
          </p>
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
    <input type="hidden" id="listMaps" value="{{$maps}}">
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


        var str = $("#listMaps").val();
        let arr = str.split(',');  
        var listMark = [];
        var listRoutes = [];
        var origin;
        var destination;
        var i = 0;
        arr.forEach((item) => 
        {
            let arr2 = item.split('|');
            let objMaps =["",parseFloat(arr2[0]),parseFloat(arr2[1]),(Math.floor(Math.random() * 4)+1)];
            
            listMark.push(objMaps);
            if(i == 0)
            {
              origin = new google.maps.LatLng(parseFloat(arr2[0]), parseFloat(arr2[1]));
            }else if (i == arr.length-1)
            {
              destination = new google.maps.LatLng(parseFloat(arr2[0]), parseFloat(arr2[1]));
            }else{
              listRoutes.push({
                  location: new google.maps.LatLng(parseFloat(arr2[0]), parseFloat(arr2[1])),
                  stopover: true,
                });
            }
            i++;
        });
        
        /*const beaches = [
          ["Bondi Beach", -33.890542, 151.274856, 4],
          ["Coogee Beach", -33.923036, 151.259052, 5],
          ["Cronulla Beach", -34.028249, 151.157507, 3],
          ["Manly Beach", -33.80010128657071, 151.28747820854187, 2],
          ["Maroubra Beach", -33.950198, 151.259302, 1],
        ];*/
        function initialize_map() { 

          const directionsService = new google.maps.DirectionsService();
          

          //var myOptions = { zoom: 13, mapTypeId: google.maps.MapTypeId.ROADMAP};
          const beach = listMark[0];
          
          //const myLatLng = { lat: beach[1], lng: beach[2]  };
          const myLatLng = { lat: parseFloat($("#lat_initial").val()), lng: parseFloat($("#lng_initial").val()) };
          //const myLatLng = { lat: 41.85, lng: -87.65  };
          const map = new google.maps.Map(document.getElementById("map_canvas"), {
            zoom:13,
            center: myLatLng,
          });


          if(listMark.length < 2)
          {
            setMarkers(map);
          }else
          {
            directionsRenderer = new google.maps.DirectionsRenderer({map: map, suppressMarkers: true});
            
            directionsService
            .route({
              origin: origin,
              destination: destination,
              waypoints: listRoutes,
              optimizeWaypoints: true,
              travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
              
              directionsRenderer.setDirections(response);

              var my_route = response.routes[0];
              for (var i = 0; i < my_route.legs.length; i++) {
                  var marker = new google.maps.Marker({
                      position: my_route.legs[i].start_location,
                      label: ""+(i+1),
                      map: map
                  });
              }
              var marker = new google.maps.Marker({
                  position: my_route.legs[i-1].end_location,
                  label: ""+(i+1),
                  map: map
              });
            })
            .catch((e) => window.alert("Directions request failed due to " + status));
          }
          //setMarkers(map);

          //setMarkers(map);

           
        }

        function setMarkers(map) {

          const shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: "poly",
          };

          for (let i = 0; i < listMark.length; i++) {
            const beach = listMark[i];

            new google.maps.Marker({
              position: { lat: beach[1], lng: beach[2] },
              map,
              shape: shape,
              title: beach[0],
              label: `${i + 1}`,
              zIndex: beach[3],
            });
          }
        }

        google.maps.event.addDomListener(window, "load", initialize_map); //]]> 


    </script> 

@endsection