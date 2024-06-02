@extends('layout')

@section('title', 'Mi perfil')

@section('content')
<div class="container mt-4"> 
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"> 
                    <img src="{{ $imagenURL }}" class="img-fluid" alt="Imagen de perfil" id="imagen-perfil">  
                    <form id="updatefoto" action="{{ route('perfil.updatefoto') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="form-group mt-3 text-center">
                            <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil" accept=".jpg, .jpeg, .png">
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-success mb-2">Actualizar Foto</button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center"> 
                        <button type="button" class="btn btn-dark mb-2" id="editar">Editar datos</button>
                        <button type="submit" class="btn btn-success mb-2" id="actualizar" style="display: none;">Actualizar</button>
                        <button type="button" class="btn btn-secondary mb-2" id="cancelar" style="display: none;">Cancelar</button>
                    </div>
                    
                    <div class="mt-3 text-center"> 
                        <button type="button" class="btn btn-danger">Eliminar perfil</button> 
                    </div>
                </div>
                <div class="col-md-4">
                    <form id="formularioupdate" action="{{ route('perfil.update', ['id' => session('user.id')]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ session('user.nombre') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ session('user.apellidos') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" name="email" value="{{ session('user.email') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fecha_creacion">Fecha de creación</label>
                            <input type="text" class="form-control" id="fecha_creacion" value="{{ date('d-m-Y', strtotime(session('user.fecha_creacion'))) }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <input type="text" class="form-control" id="rol" value="{{ App\constantes::arrTipoUsuarios[session('user.rol')] }}" disabled>
                        </div>
                        @if(session('user.id') === 2)
                        <div class="form-group">
                            <label for="NIA">NIA</label>
                            <input type="text" class="form-control" id="NIA" value="{{ session('user.NIA') }}" disabled>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="text-right mt-4">
                <button type="button" class="btn btn-primary" id="bntMatr" >Matriculacion</button>
            </div>
        </div>
    </div>
    
    <!-- Formulario de Matrícula -->
    <div class="card mt-4" id="formularioMatricula" style="display: none;">
        <div class="card-header" >
            <h5>Formulario de Matricula</h5>
        </div>
        <div class="card-body">
            <form id="matriculacion" action="{{ route('matriculacion') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="selectFamilia">Familias</label>
                    <select class="form-control" id="selectFamilia">
                        @foreach($familias as $familia)
                            <option value="{{ $familia->IdFamilia }}">{{ $familia->NombreFamilia }}</option>
                        @endforeach
                    </select>  
                </div>     
                <div class="form-group">
                    <label for="selectModulos">Modulos</label>
                        <select class="form-control" id="selectModulos">
                        </select>
                </div>    
                <div class="form-group">
                    <label for="selectCursos">Cursos</label>      
                    <select class="form-control" id="selectCursos">
                    </select>   
                </div>
                <div class="form-group">
                    <label for="passFamilia">Contraseña familia</label> 
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Matricularse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editar').click(function() {
            $('#nombre').prop('disabled', false);
            $('#apellidos').prop('disabled', false);
            $('#correo').prop('disabled', false);

            // Mostrar botones de "Actualizar" y "Cancelar"
            $('#actualizar').css('display', 'inline-block');
            $('#cancelar').css('display', 'inline-block');

            // Ocultar botón de "Editar datos"
            $('#editar').css('display', 'none');
        });

        $('#cancelar').click(function() {
            // Deshabilitar los campos y restablecer sus valores
            $('#nombre').val("{{ session('user.nombre') }}").prop('disabled', true);
            $('#apellidos').val("{{ session('user.apellidos') }}").prop('disabled', true);
            $('#correo').val("{{ session('user.email') }}").prop('disabled', true);

            // Ocultar botones de "Actualizar" y "Cancelar"
            $('#actualizar').css('display', 'none');
            $('#cancelar').css('display', 'none');

            // Mostrar botón de "Editar datos"
            $('#editar').css('display', 'inline-block');
        });

        $('#actualizar').click(function() {
            if (confirm('¿Estás seguro de que deseas actualizar tus datos?')) {
                $('#formularioupdate').submit(); // Enviar el formulario si se confirma la actualización
            }
        });

        $('#bntMatr').click(function() {
            $('#formularioMatricula').css('display', 'block');
        });

    // Función para obtener y cargar los cursos
        function cargarCursos(idCiclo) {
            $.ajax({
                url: '{{ route("getCursos", ":idCiclo") }}'.replace(':idCiclo', idCiclo),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#selectCursos').empty();
                    $.each(data, function(index, curso) {
                        $('#selectCursos').append($('<option>', {
                            value: curso.IdCurso,
                            text: curso.Curso
                        }));
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Función para cargar los ciclos al inicio de la página
        function cargarCiclos(idFamiliaSeleccionada) {
            $.ajax({
                url: '{{ route("getCiclos", ":idFamilia") }}'.replace(':idFamilia', idFamiliaSeleccionada),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#selectModulos').empty();
                    $.each(data, function(index, ciclo) {
                        $('#selectModulos').append($('<option>', {
                            value: ciclo.IdCiclo,
                            text: ciclo.NombreCiclo
                        }));
                    });

                    // Obtener el primer ciclo de la lista y cargar los cursos
                    var primerCiclo = data[0];
                    if (primerCiclo) {
                        cargarCursos(primerCiclo.IdCiclo);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Cargar los ciclos al inicio de la página
        var idFamiliaSeleccionada = $('#selectFamilia').val();
        cargarCiclos(idFamiliaSeleccionada);

        // Manejar el cambio de selección de familia
        $('#selectFamilia').change(function() {
            var idFamiliaSeleccionada = $(this).val();
            cargarCiclos(idFamiliaSeleccionada);
        });

        // Manejar el cambio de selección de ciclo
        $('#selectModulos').change(function() {
            var idCicloSeleccionado = $(this).val();
            cargarCursos(idCicloSeleccionado);
        });

    });
</script>
@endsection
