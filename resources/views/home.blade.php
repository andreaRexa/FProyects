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
        

        <!-- Añade más elementos según sea necesario -->
    </ul>
    @else
        <p>No hay datos de usuario en la sesión.</p>
    @endif

    <div id="photoCarousel" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#photoCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#photoCarousel" data-slide-to="1"></li>
            <li data-target="#photoCarousel" data-slide-to="2"></li>
        </ul>

        
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="your-image-1.jpg" alt="Image 1" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="your-image-2.jpg" alt="Image 2" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="your-image-3.jpg" alt="Image 3" class="d-block w-100">
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#photoCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#photoCarousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

@endsection