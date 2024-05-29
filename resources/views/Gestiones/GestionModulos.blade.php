@extends('layout')

@section('title', 'Gestion modulos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ciclos y Cursos</h5>
                    <ul class="list-group">
                        @foreach($ciclosConCursos as $ciclo)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        <strong>ID Ciclo:</strong> {{ $ciclo->IdCiclo }}
                                    </div>
                                    <div class="col">
                                        <strong>Nombre Ciclo:</strong> {{ $ciclo->NombreCiclo }}
                                    </div>
                                    <div class="col">
                                        <strong>Familia:</strong> {{ $ciclo->NombreFamilia }}
                                    </div>
                                    <div class="col">
                                        <strong>Cursos:</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" id="selectCursos{{ $ciclo->IdCiclo }}">
                                            <option value="">Seleccionar un curso...</option>
                                            @foreach($ciclosConCursos->cursos->curso as $curso)
                                                <option value="{{ $curso->IdCurso }}">{{ $curso->Curso }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
