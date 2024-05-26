@extends('layout')

@section('title', 'Listado de Proyectos')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mt-4"> <!-- Agregar margen superior -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Filtrar Proyectos</h2>
                        <form action="{{ route('filtrado') }}" method="POST">
                            @csrf
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
                                        <option value="{{ $ciclo}}">{{ $ciclo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <select class="form-control" id="curso" name="curso">
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso }}">{{ $curso }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mt-4"> <!-- Agregar margen superior -->
                <div class="card" style="height: 80vh;">
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="table-responsive" style="height: 100%;">
                            <table class="table table-striped text-center align-middle"> <!-- Añadir clase align-middle para centrar verticalmente -->
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
                                    @if($proyectos->isEmpty())
                                        <tr>
                                            <td colspan="6">No se encuentran proyectos con los filtros seleccionados.</td>
                                        </tr>
                                    @else
                                        @foreach($proyectos as $proyecto)
                                            @if($proyecto->Estado === 0)
                                            <tr>
                                                <td>
                                                    <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->nombre }}" style="width: 150px; height: 150px; object-fit: cover;" class="img-fluid">
                                                </td>
                                                <td class="align-middle">{{ $proyecto->NombreProyecto }}</td>
                                                <td class="align-middle">{{ $proyecto->Descripcion }}</td>
                                                <td class="align-middle">
                                                    @if ($proyecto->proyectoAlumno && $proyecto->proyectoAlumno->usuario && $proyecto->proyectoAlumno->usuario->alumnoCiclo && $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo)
                                                        {{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->NombreCiclo }}
                                                    @else
                                                        <!-- Manejo de caso en que los objetos sean null -->
                                                        No disponible
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</td>
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
            </div>
        </div>
    </div>
@endsection
