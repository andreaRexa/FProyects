@extends('layout')

@section('title', 'Principal')

@section('content')
    @if(session()->has('user'))
    <h1>Datos del Usuario en la Sesión:</h1>
    <ul>
        <li>ID: {{ session('user.id') }}</li>
        <li>Nombre: {{ session('user.nombre') }}</li>
        <li>Apellidos: {{ session('user.apellidos') }}</li>
        <li>Email: {{ session('user.email') }}</li>
        <li>Rol: {{ session('user.rol') }}</li>
        <li>FechaCreacion: {{ session('user.fecha_creacion') }}</li>
        <li>foto: {{ session('user.foto') }}</li>

        <!-- Añade más elementos según sea necesario -->
    </ul>
    @else
        <p>No hay datos de usuario en la sesión.</p>
    @endif
@endsection