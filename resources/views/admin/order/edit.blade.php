@extends('admin.app')

@section('contentCSS')
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
          <h3 class="card-title">Actualización de Pedidos</h3>

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
        <form action="{{ route('order.update', $data->id) }}" method="post">
            @csrf
            @method('PUT')         
            <div class="form-group">
                <label for="exampleInputEmail1">Cliente</label>
                <select class="form-control" name="client_id" id="client_id">
                @foreach ($cliente as $item)
                    <option value="{{$item->id}}" @if($data->client_id === $item->id) selected @endif >{{$item->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Conductor</label>
                <select class="form-control" name="conductor_id" id="categoryProduct_id">
                @foreach ($conductor as $item)
                    <option value="{{$item->id}}" @if($data->conductor_id === $item->id) selected @endif >{{$item->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Vendedor</label>
                <select class="form-control" name="vendedor_id" id="vendedor_id">
                @foreach ($vendedor as $item)
                    <option value="{{$item->id}}" @if($data->vendedor_id === $item->id) selected @endif >{{$item->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Fecha de Entrega</label>
                <input type="date" class="form-control" id="shipping_date" name="shipping_date" min="<?php echo date('Y-m-d');?>" value="{{$data->shipping_date}}" required >
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Estado</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" @if ($data->status === 1) selected @endif >Activo</option>
                    <option value="0" @if ($data->status === 0) selected @endif >Inactivo</option>
                </select>
            </div>

            <input type="hidden" name="id_products" id="id_products" value="">
            <input type="hidden" name="id_products2" id="id_products2" value="{{$data->products}}">

            <div class="form-group">
                <label for="exampleInputEmail1">Producto</label>
                <button type="button" class="btn btn-secondary" id="btnAddProduct" data-toggle="modal" data-target="#modalProduct">Agregar Producto</button>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th style="width: 40px">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyProduct">
                    
                  </tbody>
                </table>

            
            </div>

            <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tbl-product" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th></th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($product as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><input type="number" step="1" class="number-product{{ $item->id }}" style="width:50px" value="0" min="0" max="{{$item->quantity }}"></td>
                                    <td><button type="button" class="btn-add" data-id="{{ $item->id }}" data-name="{{ $item->name }}"><i class="fa fa-plus"></i></button></td>
                                </tr> 
                            @endforeach                   
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="{{route('order.index')}}" class="btn btn-danger">Cancelar</a>
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
        
        var products = [];

        $(function () {
            $('#tbl-product').DataTable({
            "responsive": true,
            "autoWidth": false,
            "lengthChange": false,
            "info": false,
            });
        });

        $(".btn-add").click(function(){
            // console.log($(this).data("id"))
            // console.log($(".number-product"+$(this).data("id")).val())
            // console.log($(".number-product"+$(this).data("id")).attr("max"));

            var id = $(this).data("id");
            var name = $(this).data("name");
            var quantity = $(".number-product"+$(this).data("id")).val();
            var quantity_max = $(".number-product"+$(this).data("id")).attr("max");

            if(quantity > 0)
            {
                if(parseInt(quantity) > parseInt(quantity_max))
                {
                    alert("Debe agregar una cantidad menor a " + quantity_max)
                }else{
                    agregar(id,name,parseInt(quantity),parseInt(quantity_max));
                }

            }else{
                alert("Debe agregar una cantidad mayor a cero")
            }
            $(".number-product"+$(this).data("id")).val(0)
        });

        function agregar(id,name,quantity,quantity_max)
        {

            var product_search = products.find(product => product.id === id);            

            if(product_search!=null)
            {
                if(product_search.quantity + quantity > quantity_max)
                {
                    if(quantity_max - product_search.quantity == 0){
                        alert("Ya completo el stock del producto");
                    }else{
                        alert("Debe agregar una cantidad menor a " + (quantity_max - (product_search.quantity)))
                    }
                   
                }else{
                    products= products.map(product=>{
                        let properties = {
                            "id": product.id,
                            "quantity": product.quantity,
                            "name": product.name
                        };
                        if(product.id == id) properties['quantity'] = parseInt(product.quantity) + parseInt(quantity)
                        return properties;
                    });
                }
                
            }else{
                let product ={id,quantity,name};
                products.push(product);
            }

            mostrar();
        }

        function mostrarinit()
        {
            let htmlProduct = "";
            products.forEach((item,index) => 
            {
                htmlProduct += `<tr>
                                    <td>${index+1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.quantity}</td>
                                    <td><button type="button" onclick='eliminar(${item.id})'><i class="fa fa-trash"></i></button></td>
                                </tr>`;
            });

            $("#tbodyProduct").html(htmlProduct)
        }

        function mostrar()
        {
            let htmlProduct = "";
            var productsList = "";
            products.forEach((item,index) => 
            {
                htmlProduct += `<tr>
                                    <td>${index+1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.quantity}</td>
                                    <td><button type="button" onclick='eliminar(${item.id})'><i class="fa fa-trash"></i></button></td>
                                </tr>`;

                productsList += `${item.id}|${item.quantity},`;
            });

            $("#tbodyProduct").html(htmlProduct)

            productsList=  productsList.substring(0, productsList.length - 1);
            $("#id_products").val(productsList);
        }

        function eliminar(id)
        {
            products = products.filter(function( obj ) {return obj.id != id;}); 
            mostrar();
        }

        var str = $("#id_products2").val();
        let arr = str.split(',');

        console.log(arr)

        arr.forEach((item) => 
        {
            let arr2 = item.split('|');

            let product ={id:parseInt(arr2[0]),quantity:parseInt(arr2[1]),name:arr2[2]};
            products.push(product);
        });
        mostrar();
    </script>


@endsection