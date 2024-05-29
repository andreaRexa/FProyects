@extends('layout')

@section('title', 'Gestion modulos')

@section('content')
<div class="container d-flex justify-content-center align-items-start min-vh-100 mt-5">
    <div class="row w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Ciclos</h5>
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-hover">
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
                                    <tr class="ciclo-item" data-ciclo-id="{{ $ciclo->IdCiclo }}">
                                        <td>{{ $ciclo->IdCiclo }}</td>
                                        <td>{{ $ciclo->NombreCiclo }}</td>
                                        <td>{{ $ciclo->NombreFamilia }}</td>
                                        <td>
                                            <select class="form-control select-cursos" id="selectCursos{{ $ciclo->IdCiclo }}">
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
                    <div class="text-center mt-4">
                        <button id="btn-editar-ciclo" class="btn btn-primary">Editar ciclo</button>
                        <form id="form-eliminar-ciclo" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button id="btn-eliminar-ciclo" class="btn btn-danger">Eliminar ciclo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Formulario de edición -->
            <div class="card card-formulario" style="display:none;">
                <div class="card-body">
                    <h5 class="card-title text-center">Editar ciclo</h5>
                    <form id="form-editar-ciclo" action="{{ route('modulos.editar') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="ciclo_id" name="ciclo_id">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text"  class="form-control" id="nombre" name="nombre" placeholder="Nombre del Ciclo">
                        </div>
                        <div class="form-group">
                            <label for="cursos">Cursos</label>
                            <div class="d-flex justify-content-between">
                                <select multiple class="form-control" id="cursosDelCiclo" style="width: 45%; height: 150px;">
                                    <!-- Cursos del ciclo -->
                                </select>
                                <div class="d-flex flex-column justify-content-center mx-2">
                                    <button type="button" id="btn-add-curso" class="btn btn-primary mb-2">&rarr;</button>
                                    <button type="button" id="btn-remove-curso" class="btn btn-primary">&larr;</button>
                                </div>
                                <select multiple class="form-control" id="cursosDisponibles" style="width: 45%; height: 150px;">
                                    <!-- Cursos disponibles -->
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" id="btn-cancelar" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var cicloSeleccionado;

        $('.ciclo-item').click(function() {
            $('.ciclo-item').removeClass('table-active');
            $(this).addClass('table-active');
            cicloSeleccionado = $(this);
        });

        $('#btn-editar-ciclo').click(function() {
            if (cicloSeleccionado) {
                var cicloId = cicloSeleccionado.data('ciclo-id');
                var nombreCiclo = cicloSeleccionado.find('td').eq(1).text();
                var cursosDelCiclo = cicloSeleccionado.find('select option');

                $('#nombre').val(nombreCiclo);
                $('#ciclo_id').val(cicloId);
                $('#cursosDelCiclo').empty();
                $('#cursosDisponibles').empty();

                cursosDelCiclo.each(function() {
                    $('#cursosDelCiclo').append($('<option>', {
                        value: $(this).val(),
                        text: $(this).text()
                    }));
                });

                var cursosDelCicloIds = cursosDelCiclo.map(function() {
                    return $(this).val();
                }).get();

                @foreach($cursosDisponibles as $curso)
                    if (!cursosDelCicloIds.includes('{{ $curso->IdCurso }}')) {
                        $('#cursosDisponibles').append($('<option>', {
                            value: '{{ $curso->IdCurso }}',
                            text: '{{ $curso->Curso }}'
                        }));
                    }
                @endforeach

                $('.card-formulario').show();
            } else {
                alert('Por favor, selecciona un ciclo antes de editar.');
            }
        });

        $('#btn-eliminar-ciclo').click(function(e) {
            e.preventDefault();
            if (cicloSeleccionado) {
                var cicloId = cicloSeleccionado.data('ciclo-id');
                $('#form-eliminar-ciclo').attr('action', '/modulos/' + cicloId).submit();
            } else {
                alert('Por favor, selecciona un ciclo antes de eliminar.');
            }
        });

        $('#btn-add-curso').click(function() {
            $('#cursosDelCiclo option:selected').appendTo('#cursosDisponibles');
        });

        $('#btn-remove-curso').click(function() {
            $('#cursosDisponibles option:selected').appendTo('#cursosDelCiclo');
            
        });

        $('#btn-cancelar').click(function() {
            $('.card-formulario').hide();
        });
    });
</script>

@endsection
