@extends('layout')

@section('title', 'Lista de Proyectos')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Proyectos</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre del Proyecto</th>
                            <th>Descripción</th>
                            <th>Ciclo</th>
                            <th>Curso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($proyectos->isEmpty())
                            <tr>
                                <td colspan="6">No se encuentran proyectos con los filtros seleccionados.</td>
                            </tr>
                        @else
                            @foreach($proyectos as $proyecto)
                                @if($proyecto->Estado === 0)
                                <tr>
                                    <td>
                                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" style="width: 150px; height: 150px; object-fit: cover;" class="img-fluid">
                                    </td>
                                    <td class="align-middle">{{ $proyecto->NombreProyecto }}</td>
                                    <td class="align-middle">{{ $proyecto->Descripcion }}</td>
                                    @php
                                        $firstAlumno = $proyecto->proyectoAlumnos->first();
                                    @endphp
                                    <td class="align-middle">{{ optional(optional($firstAlumno)->usuario->alumnoCiclo->ciclo)->NombreCiclo }}</td>
                                    <td class="align-middle">{{ optional(optional($firstAlumno)->usuario->alumnoCiclo)->FechaCurso }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('proyectos.detalle', $proyecto->IdProyecto) }}" class="btn btn-primary">Ver más</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
