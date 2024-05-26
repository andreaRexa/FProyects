@extends('layout')

@section('title', $proyecto->NombreProyecto)

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">{{ $proyecto->NombreProyecto }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="card-img">
                        <h5 class="card-title mt-4">Descripción</h5>
                        <p class="card-text">{{ $proyecto->Descripcion }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Información del Proyecto</h5>
                        <ul class="list-group">
                            <li class="list-group-item">Ciclo: {{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->NombreCiclo }}</li>
                            <li class="list-group-item">Curso: {{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</li>
                            <!-- Agrega más detalles del proyecto aquí -->
                        </ul>
                        <div class="mt-4">
                            <h5 class="card-title">Archivos</h5>
                            <!-- Agrega aquí la sección para mostrar archivos relacionados con el proyecto -->
                        </div>
                        <div class="mt-4">
                            <h5 class="card-title">Documentación</h5>
                            <!-- Agrega aquí la sección para mostrar la documentación relacionada con el proyecto -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
