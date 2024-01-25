@extends('admin.app')

@section('contentCSS')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- DataTables -->
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
        <a class="btn btn-success" href={{ route('order.create') }}>Agregar</a>
          <table id="tableDT" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>OrderId</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Conductor</th>
                <th>Cantidad</th>
                <th>Fecha Envio</th>
                <th>Comprobante</th>
                <th>Estado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($data as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cliente }}</td>
                <td>{{ $item->vendedor }}</td>
                <td>{{ $item->conductor }}</td>
                <td>{{ $item->productos }}</td>
                <td>{{ $item->shipping_date }}</td>
                <td> <a href="{{ route('order.print', $item->id) }}" class="btn btn-success"><i class="fa fa-eye"></i> </a></td>
                <td>@if ($item->status === 1) Activo @else Inactivo @endif</td>
                <td>
                  <a href="{{ route('order.edit', $item->id) }}" class="btn btn-primary"><i class="fa fa-pen"></i> Editar</a>
                  
                  <form action="{{ route('order.destroy', $item->id) }}" method="post" style="display: inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i>Delete</button>
                    </form>
                    
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
                <th>Cantidad</th>
                <th>Fecha Envio</th>
                <th>Comprobante</th>
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
  <input type="hidden" id="routeProduct" value="{{route('pickup.product')}}">
  <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mostrar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="print-order">

                <div class="text-bold text-right pb-3">Orden número: <span id="numberOrder">000001</span></div>

                <div class="d-flex justify-content-around pb-3">
                  <div> 
                      <div> <span class="text-bold">Cliente:</span> <span id="clientName">Nombre Cliente 1</span></div>
                      <div> <span class="text-bold">Dirección:</span> <span id="clientAddress">Los naranjos 132</span></div>
                  </div>
                  <div>
                    <div> <span class="text-bold">Conductor:</span> <span id="driverName">Conductor 1</span></div>
                    <div> <span class="text-bold">Vendedor:</span> <span id="sellerName">Vendedor 1</span></div>
                  </div>
                </div>

                <table id="tbl-product" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="window.print();">Imprimir</button>
            </div>
            </div>
        </div>
    </div>
 

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
            let total = 0;
            respu["data"].forEach((item,index) => 
            {
                htmlProduct += `<tr>
                                    <td>${index+1}</td>
                                    <td>${item.product}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price}</td>
                                    <td>${item.quantity*item.price}</td>
                                </tr>`;
              total += item.quantity*item.price;
            });

            htmlProduct += `<tr>
                              <td class="text-center text-bold" colspan="4">Total</td>
                              <td>${total}</td>
                            </tr>`;
            $("#tbl-product tbody").html(htmlProduct);
            $("#modalProduct").modal("show");
        },
        error: function(error)
        {
            console.log(error)
        }
    });
  }

  function print22(id){

    var content = document.getElementById(id).innerHTML;
      ventana=window.open("about :blank","ventana","width=700,height=600,top=0,left=3000");
      ventana.document.open();
      ventana.document.write('<html><head><title>Imprimiendo...</title></head><body onprint="self.close()">');
      ventana.document.write(content);
      ventana.document.write('</body></html>');
      ventana.document.close();
      ventana.print();
      ventana.focus();
      ventana.close();

  } 

</script>

@endsection