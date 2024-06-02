@extends('layout')

@section('title', 'Gestion Alumnos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-7 mt-4">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th colspan="5">Lista de alumnos</th>
                        </thead>
                        <tbody>
                            @foreach($alumnos->chunk(5) as $chunk)
                                <tr>
                                    @foreach($chunk as $alumno)
                                        <td class="text-center">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($alumno->FotoUsuario) }}" alt="Foto de {{ $alumno->Nombre }}" class="img-fluid rounded" style="width: 100px; height: 100px;">
                                            <div>{{ $alumno->Apellidos }}, {{ $alumno->Nombre }}</div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Solicitudes pedientes</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->Nombre }}</td>
                                    <td>{{ $usuario->Apellidos }}</td>
                                    <td>{{ $usuario->Correo }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" id = "btnFromSol">✔️</button>
                                        <input type="hidden" name="IdUsu" value="{{ $usuario->IdUsuario }}">
                                        <form action="{{ route('eliminarsol') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="IdSolicitud" value="{{ $usuario->IdSolicitud }}">
                                            <button type="submit" class="btn btn-sm btn-danger">❌</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4" id="formularioAprobar" style="display: none;">
                <div class="card-body">
                    <h4 class="card-title">Aprobar Solicitud</h4>
                    <form action="{{ route('aprobarSolicitud') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach($usuarios as $usuario)
                                <div class="col-md-4">
                                    <img src="" id="foto" class="img-fluid rounded" style="width: 100px; height: 100px;">
                                </div>                           
                                <div class="col-md-8">                           
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre:</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos:</label>
                                        <input type="text" id="apellidos" name="apellidos" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo:</label>
                                <input type="email" id="correo" name="correo" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ciclo" class="form-label">Ciclo:</label>
                                <input type="text" id="ciclo" name="ciclo" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="curso" class="form-label">Curso:</label>
                                <input type="text" id="curso" name="curso" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nia" class="form-label">NIA:</label>
                                <input type="text" id="nia" name="nia" class="form-control" required>
                            </div>
                            @endforeach
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var fotoUsuario = '{{ $usuario->FotoUsuario }}';
    $(document).ready(function() {
        $('#btnFromSol').click(function(e) {
            e.preventDefault();
            var IdUsu = $(this).siblings("input[name='IdUsu']").val();
            var usuario = $.grep(usuarios, function(obj){return obj.IdUsuario === IdUsu;})[0];
            $('#foto').attr('src', 'data:image/jpeg;base64,' + fotoUsuario);
            $('#nombre').val(usuario.Nombre);
            $('#apellidos').val(usuario.Apellidos);
            $('#correo').val(usuario.Correo);
            $('#ciclo').val(usuario.Nombreciclo);
            $('#curso').val(usuario.Curso);
            $('#formularioTarjeta').show();
        });

        $('#cancelar').click(function() {
            $('#formularioTarjeta').hide();
        });
    });
</script>

@endsection
