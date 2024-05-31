@extends('layout')

@section('title', 'Recuperar contraseña')

@section('content')
    <!-- Formulario para ingresar el código y restablecer la contraseña -->
    <form action="{{ route('password.resetPass') }}" method="POST" id="ResetPass" style="display: none;">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <label for="code">Código de recuperación:</label>
            <input type="text" class="form-control" id="code" name="code" required>
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

@endsection