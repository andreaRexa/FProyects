@extends('layout')

@section('title', 'Principal')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color: #333; font-size: 24px; font-weight: bold;">Top proyectos del mes</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="photoCarousel" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                        @foreach($proyectos as $index => $proyecto)
                            <li data-target="#photoCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ul>

                    <div class="carousel-inner">
                        @foreach($proyectos as $index => $proyecto)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="d-block w-100" style="max-width: 500px; max-height: 300px; object-fit: cover; margin: 0 auto;">
                                <div class="carousel-caption d-none d-md-block"> 
                                    <h5>{{ $proyecto->NombreProyecto }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a class="carousel-control-prev" href="#photoCarousel" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#photoCarousel" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
