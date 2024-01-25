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
            <h1>Product Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Page</li>
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
          <h3 class="card-title">Actualización de Producto</h3>

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
        <form action="{{ route('product.update', $data->id) }}" method="post">
            @csrf
            @method('PUT')         
            <div class="form-group">
                <label for="exampleInputEmail1">Descripción</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Categoría" value="{{ $data->name }}"  required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Categoría</label>
                <select class="form-control" name="categoryProduct_id" id="categoryProduct_id">
                @foreach ($category as $item)
                    <option value="{{$item->id}}" @if ($data->categoryProduct_id === $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="number" step="any" class="form-control" id="price" name="price" required value="{{ $data->price }}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Cantidad</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required value="{{ $data->quantity }}">
            </div>            
            <div class="form-group">
                <label for="exampleInputEmail1">Estado</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" @if ($data->status === 1) selected @endif >Activo</option>
                    <option value="0" @if ($data->status === 0) selected @endif >Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="{{route('product.index')}}" class="btn btn-danger">Cancelar</a>
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


@endsection