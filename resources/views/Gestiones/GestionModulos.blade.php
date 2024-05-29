@extends('layout')

@section('title', 'Gestion modulos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ciclos</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Ciclo</th>
                                    <th>Nombre</th>
                                    <th>Familia</th>
                                    <th>Cursos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ciclos as $ciclo)
                                    <tr class="curso-item" data-curso-id="{{ $ciclo->IdCiclo }}">
                                        <td>{{ $ciclo->IdCiclo }}</td>
                                        <td>{{ $ciclo->NombreCiclo }}</td>
                                        <td>{{ $ciclo->NombreFamilia }}</td>
                                        <td>
                                            <select class="form-control select-cursos" id="selectCursos{{ $ciclo->IdCiclo }}">
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

<script>
    $(document).ready(function() {
        $('.curso-item').click(function() {
            // Remover la clase de selección de todas las filas
            $('.curso-item').removeClass('table-active');
            
            // Agregar la clase de selección solo a la fila clicada
            $(this).addClass('table-active');
        });
    });
</script>

@endsection
