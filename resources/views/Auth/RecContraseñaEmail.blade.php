@extends('layout')

@section('title', 'Recuperar contraseña')
    <!-- Formulario para enviar correo electrónico con el código de recuperación -->
    <form action="{{ route('password.enviarcod') }}" method="POST" id="FormCodigo">
        @csrf
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar código de recuperación</button>
    </form>

@endsection