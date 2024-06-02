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
                                        <button type="button" class="btn btn-sm btn-success btnFromSol"
                                                data-nombre="{{ $usuario->Nombre }}"
                                                data-apellidos="{{ $usuario->Apellidos }}"
                                                data-correo="{{ $usuario->Correo }}"
                                                data-ciclo="{{ $usuario->Nombreciclo }}"
                                                data-curso="{{ $usuario->Curso }}"
                                                data-idusu="{{ $usuario->IdUsuario }}"
                                                data-idciclo="{{ $usuario->IdCiclo }}"
                                                data-idfam="{{ $usuario->IdFamilia }}">
                                            ✔️
                                        </button>
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
                            <div class="col-md-6">
                                <input type="text" id="usuId" name="usuId" class="form-control" readonly>
                                <input type="text" id="cicloId" name="cicloId" class="form-control" readonly>
                                <input type="text" id="famId" name="famId" class="form-control" readonly>
                                <div class="mb-3">
                                    <label for="nombreIn" class="form-label">Nombre:</label>
                                    <input type="text" id="nombreIn" name="nombreIn" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">Apellidos:</label>
                                    <input type="text" id="apellidos" name="apellidos" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo:</label>
                                    <input type="email" id="correo" name="correo" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                <button type="button" id="cancelar" class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnFromSol').click(function(e) { 
            $('#nombreIn').val($(this).data('nombre'));
            $('#apellidos').val($(this).data('apellidos'));
            $('#correo').val($(this).data('correo'));
            $('#ciclo').val($(this).data('ciclo'));
            $('#curso').val($(this).data('curso'));
            $('#usuId').val($(this).data('idusu'));
            $('#cicloId').val($(this).data('idciclo'));
            $('#famId').val($(this).data('idfam'));
            
            $('#formularioAprobar').css('display', 'inline-block');
        });  

        $('#cancelar').click(function() {
            $('#formularioAprobar').css('display', 'none');
        });
    });

</script>
@endsection
