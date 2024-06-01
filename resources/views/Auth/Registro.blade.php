@extends('layout')

@section('title', 'Registro')

@section('content')    
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Registro</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('registro') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="Nombre">Nombre:</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="Apellidos">Apellidos:</label>
                                <input type="text" class="form-control" id="Apellidos" name="Apellidos" required>
                            </div>
                            <div class="form-group">
                                <label for="Correo">Correo:</label>
                                <input type="email" class="form-control" id="Correo" name="Correo" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar contraseña:</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <label for="FotoUsuario">Foto de Usuario:</label>
                                <input type="file" class="form-control-file" id="FotoUsuario" name="FotoUsuario" accept=".jpg, .jpeg, .png">
                            </div>

                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
  