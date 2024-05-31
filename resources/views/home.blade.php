@extends('layout')

@section('title', 'Principal')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color: #fff; font-size: 32px; font-weight: bold; padding: 10px;">Top proyectos del mes</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="photoCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($proyectos as $index => $proyecto)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="card">
                                <a href="{{ route('proyectos.detalle', $proyecto->IdProyecto) }}"> <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="d-block w-100" style="max-width: 500px; max-height: 300px; object-fit: cover; margin: 0 auto;"></a>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $proyecto->NombreProyecto }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#photoCarousel" role="button" data-slide="prev" style="color: #007bff;">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#photoCarousel" role="button" data-slide="next" style="color: #007bff;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
                <ol class="carousel-indicators mt-3">
                    @foreach($proyectos as $index => $proyecto)
                        <li data-target="#photoCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" style="background-color: #007bff;"></li>
                    @endforeach
                </ol>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #333; font-size: 24px; font-weight: bold;">¿Cuál es el objetivo de FProyects?</h5>
                        <p class="card-text" style="color: #555;">A lo largo de los años, muchos proyectos con ideas muy buenas y con mucho esfuerzo se pierden. Fprojects evita eso sirviendo como una especie de biblioteca de proyectos que todo el mundo puede consultar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
