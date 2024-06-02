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
                            @foreach($alumnos as $alumno)
                            <tr>
                                <td>
                                    <img src="{{ $alumno->FotoUsuario }}" alt="Foto de {{ $alumno->Nombre }}" class="img-fluid rounded-circle mr-2" style="max-width: 50px;">
                                    <span>{{ $alumno->Nombre }} {{ $alumno->Apellido }}</span>
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
