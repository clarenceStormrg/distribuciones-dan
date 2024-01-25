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
            <h1>User Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Page</li>
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
          <h3 class="card-title">Actualización de Usuario</h3>

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
        <form action="{{ route('user.update', $data->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="exampleInputEmail1">Usuario</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $data->email }}" required>
            </div>            
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Nombre" value="{{ $data->name }}"  required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Perfil</label>
                <select class="form-control" name="idPerfil" id="idPerfil">
                    <option value="1" @if ($data->idPerfil === 1) selected @endif  >Administrador</option>
                    <option value="2" @if ($data->idPerfil === 2) selected @endif  >Vendedor</option>
                    <option value="3" @if ($data->idPerfil === 3) selected @endif  >Conductor</option>
                </select>
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
                <a href="{{route('user.index')}}" class="btn btn-danger">Cancelar</a>
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