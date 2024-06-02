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

        <!-- Lista de alumnos con detalles en 4 columnas -->
        <div class="col-lg-5 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Solicitudes pedientes</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <img src="data:image/jpeg;base64,{{ base64_encode($alumno->FotoUsuario) }}" alt="Foto de {{ $alumno->Nombre }}" class="img-fluid rounded" style="width: 50px; height: 50px;">
                                    </td>
                                    <td>{{ $alumno->Nombre }}</td>
                                    <td>{{ $alumno->Apellidos }}</td>
                                    <td>{{ $alumno->Correo }}</td>
                                    <td>
                                        <a href="" class="btn btn-sm btn-success">✔️</a>
                                        <form action="" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
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
