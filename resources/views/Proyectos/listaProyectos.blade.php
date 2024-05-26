@extends('layout')

@section('title', 'Listado de Proyectos')

@section('content')
    <h1>Listado de Proyectos</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover"> <!-- Agregamos la clase 'table-bordered' para bordes en la tabla y 'table-hover' para resaltar filas al pasar el cursor -->
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Foto</th> <!-- Usamos 'scope="col"' para especificar que es un encabezado de columna -->
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Ciclo</th>
                    <th scope="col">Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $proyecto)
                    <tr>
                        <td>
                            <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->nombre }}" style="max-width: 100px;" class="img-fluid">
                        </td>
                        <td>{{ $proyecto->NombreProyecto }}</td>
                        <td>{{ $proyecto->Descripcion }}</td>
                        <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->NombreCiclo }}</td>
                        <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
