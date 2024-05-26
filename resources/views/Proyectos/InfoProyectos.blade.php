@extends('layout')

@section('title', $proyecto->NombreProyecto)

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ $proyecto->NombreProyecto }}</h5>
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">&laquo; Volver</a>
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
                            @php
                                $firstAlumno = $proyecto->proyectoAlumno->first();
                            @endphp
                            <li class="list-group-item">Ciclo: {{ optional(optional($firstAlumno)->usuario->alumnoCiclo->ciclo)->NombreCiclo }}</li>
                            <li class="list-group-item">Curso: {{ optional(optional($firstAlumno)->usuario->alumnoCiclo)->FechaCurso }}</li>
                            <li class="list-group-item">Fecha subida: {{ $proyecto->Fecha }}</li>
                            <li class="list-group-item">Familia: {{ $proyecto->familia->NombreFamilia }}</li>
                            
                                @php
                                    $autores = $proyecto->proyectoAlumnos->map(function($proyectoAlumno) {
                                        return $proyectoAlumno->usuario->Nombre . ' ' . $proyectoAlumno->usuario->Apellidos;
                                    })->implode(', ');
                                @endphp
                                <li class="list-group-item">Autores: {{ $autores }}</li>
                            
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
