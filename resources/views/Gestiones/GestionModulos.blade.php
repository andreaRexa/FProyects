@extends('layout')

@section('title', 'Gestion modulos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
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
                                    <tr class="ciclo-item" data-ciclo-id="{{ $ciclo->IdCiclo }}">
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
        <div class="col-md-4">
            <!-- Formulario de edición -->
            <div class="card card-formulario" id="formulario-edicion" style="display: none;">
                <div class="card-body">
                    <h5 class="card-title">Editar ciclo</h5>
                    <form action="{{ route('modulos.editar') }}" method="POST">
                        @csrf
                        <!-- Campo oculto para el ID del ciclo -->
                        <input type="hidden" id="ciclo-seleccionado-id" name="ciclo_id">

                        <!-- Campos del formulario para editar el módulo -->
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Módulo">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Botones de eliminar y editar -->
    <div class="row mt-3">
        <div class="col-md-8">
            <form action="" method="POST" id="form-eliminar-ciclo">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" id="btn-eliminar-ciclo">Eliminar ciclo</button>
            </form>
            <a href="#" class="btn btn-primary" id="btn-editar-ciclo">Editar ciclo</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.ciclo-item').click(function() {
            // Remover la clase de selección de todas las filas
            $('.ciclo-item').removeClass('table-active');
            
            // Agregar la clase de selección solo a la fila clicada
            $(this).addClass('table-active');
        });

        // Mostrar el formulario de edición al hacer clic en "Editar ciclo"
        $('#btn-editar-ciclo').click(function() {
            var cicloSeleccionado = $('.ciclo-item.table-active');

            if (cicloSeleccionado.length > 0) {
                // Obtener el ID del ciclo seleccionado
                var cicloId = cicloSeleccionado.data('curso-id');
                
                // Asignar el ID del ciclo seleccionado al campo oculto del formulario
                $('#ciclo-seleccionado-id').val(cicloId);
            

                // Mostrar el formulario de edición
                $('#formulario-edicion').show();
            } else {
                // Mostrar una alerta si no se ha seleccionado ningún ciclo
                alert('Por favor, selecciona un ciclo antes de editar.');
            }
        });

        // Al hacer clic en "Eliminar ciclo"
        $('#btn-eliminar-ciclo').click(function(e) {
            e.preventDefault();

            var cicloSeleccionado = $('.ciclo-item.table-active');

            if (cicloSeleccionado.length > 0) {
                // Obtener el ID del ciclo seleccionado
                var cicloId = cicloSeleccionado.data('ciclo-id');
                
                // Asignar el ID del ciclo seleccionado al formulario de eliminación
                $('#form-eliminar-ciclo').attr('action', '{{ route("modulos.eliminar") }}/' + cicloId);

                // Enviar la solicitud de eliminación
                $('#form-eliminar-ciclo').submit();
            } else {
                // Mostrar una alerta si no se ha seleccionado ningún ciclo
                alert('Por favor, selecciona un ciclo antes de eliminar.');
            }
        });
    });
</script>


@endsection
