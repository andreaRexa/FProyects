@extends('layout')

@section('title', 'Listado de Proyectos')

@section('content')
    <h1>Listado de Proyectos</h1>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ciclo</th>
                <th>Curso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $proyecto)
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->nombre }}" style="width: 100px;">
                    </td>
                    <td>{{ $proyecto->NombreProyecto }}</td>
                    <td>{{ $proyecto->Descripcion }}</td>
                    <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->NombreCiclo }}</td>
                    <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
