@extends('layout')

@section('title', 'Principal')

@section('content')

    <div id="photoCarousel" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#photoCarousel" data-slide-to="0" class="active"></li>
            @foreach($proyectos as $index => $proyecto)
                <li data-target="#photoCarousel" data-slide-to="{{ $index + 1 }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ul>

        
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="data:image/jpeg;base64,{{ base64_encode($proyectos[0]->FotoProyecto) }}" alt="{{ $proyectos[0]->NombreProyecto }}" class="d-block w-100">
            </div>
            @foreach($proyectos as $proyecto)
                <div class="carousel-item">
                    <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="d-block w-100">
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

@endsection