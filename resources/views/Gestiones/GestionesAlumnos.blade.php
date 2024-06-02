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
                                        <a href="" class="btn btn-sm btn-success">✔️</a>
                                        <form action="{{ route('eliminarsol') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="idUsuBorrar" value="{{ $usuario->IdUsuario }}">
                                            <input type="hidden" name="idFamBorrar" value="{{ $usuario->IdFamilia }}">
                                            <input type="hidden" name="idCicloBorrar" value="{{ $usuario->IdCiclo }}">
                                            <input type="hidden" name="idCursoBorrar" value="{{ $usuario->IdCurso }}">
                                            <button type="submit" class="btn btn-sm btn-danger">❌</button>
                                        </form>
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
@endsection
