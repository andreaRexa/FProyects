@extends('layout')

@section('title', 'Gestion modulos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ciclos y Cursos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Ciclo</th>
                                    <th>Nombre Ciclo</th>
                                    <th>Familia</th>
                                    <th>Cursos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ciclos as $ciclo)
                                    <tr class="curso-item">
                                        <td>{{ $ciclo->IdCiclo }}</td>
                                        <td>{{ $ciclo->NombreCiclo }}</td>
                                        <td>{{ $ciclo->NombreFamilia }}</td>
                                        <td>
                                            <select class="form-control" id="selectCursos{{ $ciclo->IdCiclo }}">
                                                <option value="">Listado de curso</option>
                                                @foreach($ciclo->cursos as $curso)
                                                    <option value="{{ $curso->IdCurso }}">{{ $curso->curso->Curso }}</option>
                                                @endforeach
                                            </select>      
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
