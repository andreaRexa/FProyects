@extends('layout')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Recuperar contraseña</div>
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
                <!-- Formulario para ingresar el código y restablecer la contraseña -->
                <form action="{{ route('password.resetPass') }}" method="POST" id="ResetPass">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="form-group">
                        <label for="codigo">Código de recuperación:</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Nueva contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_conf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection