@extends('home')

@section('title', 'Mi perfil')

@section('content')
<div class="container mt-4"> <!-- Agregamos un margen top -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"> 
                    <img src="{{ $imagenURL }}" class="img-fluid" alt="Imagen de perfil">  
                    <div class="mt-3 text-center"> 
                        <button type="button" class="btn btn-dark mb-2" id="editar" onclick="habilitarEdicion()">Editar datos</button>
                        <button type="submit" class="btn btn-success mb-2" id="actualizar" style="display: none;" onclick="confirmarActualizacion()">Actualizar</button>
                        <button type="button" class="btn btn-secondary mb-2" id="cancelar" style="display: none;" onclick="cancelarEdicion()">Cancelar</button>
                    </div>
                    <div class="mt-3 text-center"> 
                        <button type="button" class="btn btn-danger">Eliminar perfil</button> 
                    </div>
                </div>
                <div class="col-md-5">
                <form id="update-form" action="{{ route('perfil.update', ['id' => session('user.id')]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name ="nombre" value="{{ session('user.nombre') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name ="apellidos" value="{{ session('user.apellidos') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="email" value="{{session('user.email') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fecha_creacion">Fecha de creación</label>
                            <input type="text" class="form-control" id="fecha_creacion" value="{{ date('d-m-Y', strtotime( session('user.fecha_creacion'))) }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <input type="text" class="form-control" id="rol" value="{{ App\constantes::arrTipoUsuarios[session('user.rol')] }}" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function habilitarEdicion() {
        document.getElementById('nombre').disabled = false;
        document.getElementById('apellidos').disabled = false;
        document.getElementById('correo').disabled = false;

        // Mostrar botones de "Actualizar" y "Cancelar"
        document.getElementById('actualizar').style.display = 'inline-block';
        document.getElementById('cancelar').style.display = 'inline-block';

        // Ocultar botón de "Editar datos"
        document.getElementById('editar').style.display = 'none';
    }

    function cancelarEdicion() {
        // Deshabilitar los campos y restablecer sus valores
        document.getElementById('nombre').value = "{{ session('user.nombre') }}";
        document.getElementById('apellidos').value = "{{ session('user.apellidos') }}";
        document.getElementById('correo').value = "{{ session('user.email') }}";
        document.getElementById('nombre').disabled = true;
        document.getElementById('apellidos').disabled = true;
        document.getElementById('correo').disabled = true;

        // Ocultar botones de "Actualizar" y "Cancelar"
        document.getElementById('actualizar').style.display = 'none';
        document.getElementById('cancelar').style.display = 'none';

        // Mostrar botón de "Editar datos"
        document.getElementById('editar').style.display = 'inline-block';
    }

    function confirmarActualizacion() {
        if (confirm('¿Estás seguro de que deseas actualizar tus datos?')) {
            document.getElementById('update-form').submit(); // Enviar el formulario si se confirma la actualización
        }
    }
</script>


@endsection
