@extends('layout')

@section('title', $proyecto->NombreProyecto)

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">{{ $proyecto->NombreProyecto }}</h5>
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm">&laquo; Volver</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="card-img" style="width: 250px; height: 250px; object-fit: cover;">
                        <h5 class="card-title mt-4">Descripción</h5>
                        <p class="card-text">{{ $proyecto->Descripcion }}</p>
                    </div>
                    <div class="col-md-8">
                        <h5 class="card-title">Información del Proyecto</h5>
                        <ul class="list-group">
                            <li class="list-group-item">Ciclo: {{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->NombreCiclo }}</li>
                            <li class="list-group-item">Curso: {{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</li>
                            <li class="list-group-item">Fecha subida: {{ $proyecto->Fecha}}</li>
                            <li class="list-group-item">Familia: {{ $proyecto->familia->NombreFamilia }}</li>
                            <li class="list-group-item">
                                Autores:
                                @foreach($proyecto->proyectoAlumno as $proyectoAlumno)
                                    @foreach($proyectoAlumno->usuario as $autor)
                                        {{ $autor->Nombre }} {{ $autor->Apellidos }}
                                        @unless($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                @endforeach
                            </li>

                        </ul>
                        <div class="mt-4">
                            <h5 class="card-title">Archivos</h5>
                            <h5 class="card-title">Documentación</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
