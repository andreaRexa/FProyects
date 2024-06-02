@extends('layout')

@section('title', 'Gestion Alumnos')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Gestión de Alumnos</h2>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @foreach($alumnos->chunk(5) as $chunk)
                                <tr>
                                    @foreach($chunk as $alumno)
                                        <td class="text-center">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($alumno->FotoUsuario) }}" alt="Foto de {{ $alumno->Nombre }}" class="img-fluid rounded" style="width: 150px; height: 150px;">
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Lista de elementos adicionales</h4>
                    <ul class="list-group">
                        <li class="list-group-item">Elemento 1</li>
                        <li class="list-group-item">Elemento 2</li>
                        <li class="list-group-item">Elemento 3</li>
                        <li class="list-group-item">Elemento 4</li>
                        <li class="list-group-item">Elemento 5</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
