@extends('layout')

@section('title', 'Listado de Proyectos')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4"> <!-- Columna para el formulario de filtrado -->
                <h2>Filtrar Proyectos</h2>
                <form action="" method="GET">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion">
                    </div>
                    <div class="form-group">
                        <label for="ciclo">Ciclo:</label>
                        <select class="form-control" id="ciclo" name="ciclo">
                            <option value="">Seleccione un ciclo</option>
                            @foreach($ciclos as $ciclo)
                            <option value="{{ $ciclo->NombreCiclo }}">{{ $ciclo->NombreCiclo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="curso">Curso:</label>
                        <select class="form-control" id="curso" name="curso">
                            <option value="">Seleccione un curso</option>
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->FechaCurso }}">{{ $curso->FechaCurso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
            <div class="col-md-8"> <!-- Columna para la tabla de proyectos -->
                <h2>Listado de Proyectos</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Ciclo</th>
                                <th>Curso</th>
                                <th>Acciones</th>
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
            </div>
        </div>
    </div>
@endsection
