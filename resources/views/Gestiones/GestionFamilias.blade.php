@extends('layout')

@section('title', 'Gestion familias')

@section('content')
<div class="container d-flex justify-content-center align-items-start min-vh-100 mt-5">
    <div class="row w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Familias</h5>
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Familia</th>
                                    <th>Nombre</th>
                                    <th>Familia</th>
                                    <th>ContraseniaFamilia</th>
                                    <th>Administrador</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($familias->count() === 0)
                                    <tr>
                                        <td colspan="4">No se han encontrado ciclos</td>
                                    </tr>        
                                @else
                                    @foreach($familias as $familia)
                                        <tr class="familia-item" data-familia-id="{{ $familia->IdFamilia }}">
                                            <td>{{ $familia->IdFamilia }}</td>
                                            <td>{{ $familia->NombreFamilia }}</td>
                                            <td>{{ $familia->ContraseniaFamilia }}</td>
                                            <td>{{ $familia->administrador->Nombre }}</td>
                                            <td>
                                            
                                        </tr>
                                    @endforeach
                                @endif    
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <button id="btn-nuevo-familia" class="btn btn-success">Nuevo</button>
                        <button id="btn-editar-familia" class="btn btn-primary">Editar familia</button>
                        <form id="form-eliminar-familia" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button id="btn-eliminar-familia" class="btn btn-danger">Eliminar familia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Formulario de edición -->
            <div class="card card-formulario" style="display:none;">
                <div class="card-body">
                    <h5 class="card-title text-center">Editar familia</h5>
                    <form id="form-editar-familia" action="{{ route('familia.editar') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="">
                        <select class="form-control select-cursos" name="selectAdmin">
                        </select>
                        <div class="text-center">
                            <button type="submit" id="btn-guardar" class="btn btn-primary">Guardar</button>
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
        var FamiliaSeleccionado;

        $('.ciclfamiliao-item').click(function() {
            $('.familia-item').removeClass('table-active');
            $(this).addClass('table-active');
            FamiliaSeleccionado = $(this);
        });

        $('#btn-editar-familia').click(function() {
            if (FamiliaSeleccionado) {
                var familiaId = FamiliaSeleccionado.data('familia-id');
                var nombreFamilia = FamiliaSeleccionado.find('td').eq(1).text();
                var cursosDelCiclo = FamiliaSeleccionado.find('select option');

                $('#nombre').val(nombreCiclo);
                $('#ciclo_id').val(cicloId);
                $('#accion').val("editar");
                $('#cursosDelCiclo').empty();
                $('#cursosDisponibles').empty();

                $('.card-formulario').show();
            } else {
                alert('Por favor, selecciona una familia antes de editar.');
            }
        });

        $('#btn-eliminar-familia').click(function(e) {
            e.preventDefault();
            if (cicloSeleccionado) {
                var ciIclod = cicloSeleccionado.data('ciclo-id');
                $('#form-eliminar-familia').attr('action', '/familia/' + cicloId).submit();
            } else {
                alert('Por favor, selecciona un ciclo antes de eliminar.');
            }
        });

        $('#btn-nuevo-familia').click(function() {
            
            $('.card-formulario').show();
        });


        $('#btn-cancelar').click(function() {
            $('.card-formulario').hide();
        });
    });
</script>

@endsection
