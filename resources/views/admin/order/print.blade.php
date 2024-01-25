@extends('admin.app')

@section('contentCSS')

    <style>
        @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>

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
        <div class="card-header no-print">
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
        <div class="card-body" style="font-size: 1.1rem";>
            <button class="btn btn-success no-print" type="button" onclick="window.print()">Imprimir</button>
            <a class="btn btn-primary no-print" href={{ route('order.index') }}>Pedidos</a>
            <div class="text-bold text-right pb-5">NÚMERO DE COMPROBANTE: <span id="numberOrder">{{$data_cab->id}}</span></div>

            <div class="d-flex justify-content-around pb-5">
            <div> 
                <div> <span class="text-bold">Cliente:</span> <span id="clientName">{{$data_cab->client}}</span></div>
                <div> <span class="text-bold">Dirección:</span> <span id="clientAddress">{{$data_cab->street_address}}</span></div>
            </div>
            <div>
                <div> <span class="text-bold">Conductor:</span> <span id="driverName">{{$data_cab->driver}}</span></div>
                <div> <span class="text-bold">Vendedor:</span> <span id="sellerName">{{$data_cab->seller}}</span></div>
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
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{ $item->product }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity*$item->price }}</td>
                        </tr>
                    @endforeach  
                    <tr>
                        <td class="text-center text-bold" colspan="4">SubTotal</td>
                        <td>{{$data_cab->subtotal}}</td>
                    </tr>   
                    <tr>
                        <td class="text-center text-bold" colspan="4">IGV</td>
                        <td>{{$data_cab->igv}}</td>
                    </tr>   
                    <tr>
                        <td class="text-center text-bold" colspan="4">Total</td>
                        <td>{{$data_cab->total}}</td>
                    </tr>            
                </tbody>
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

 

@endsection

@section('contentJS')


@endsection