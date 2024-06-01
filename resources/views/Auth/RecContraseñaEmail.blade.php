@extends('layout')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Enviar codigo</div>

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
                <!-- Formulario para enviar correo electrónico con el código de recuperación -->
                <form action="{{ route('password.enviarcod') }}" method="GET" id="FormCodigo">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar código de recuperación</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection