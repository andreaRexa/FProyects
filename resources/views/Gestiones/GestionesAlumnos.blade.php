@extends('layout')

@section('title', 'Gestion Alumnos')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Gestión de Alumnos</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Foto y Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos->chunk(5) as $chunk)
                                <tr>
                                    @foreach($chunk as $alumno)
                                        <td class="text-center">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($alumno->FotoUsuario) }}" alt="Foto de {{ $alumno->Nombre }}" class="img-fluid rounded" style="width: 350px; height: 350px;">
                                            <div>{{ $alumno->Nombre }} {{ $alumno->Apellido }}</div>
                                        </td>
                                    @endforeach
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
