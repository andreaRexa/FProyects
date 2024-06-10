@extends('layout')

@section('title', $proyecto->NombreProyecto)

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ $proyecto->NombreProyecto }}</h5>
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">&laquo; Volver</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="card-fluid" style="width: 250px; height: 250px; object-fit: contain;">
                        <h5 class="card-title mt-4">Descripción</h5>
                        <p class="card-text">{{ $proyecto->Descripcion }}</p>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Información del Proyecto</h5>
                            <div id="estrellas" data-rating="{{ $proyecto->MediaValoracion }}"></div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Familia: {{ $proyecto->familia->NombreFamilia }}</li>
                            <li class="list-group-item">Ciclo: {{ $proyecto->ciclo->NombreCiclo }}</li>
                            <li class="list-group-item">Curso: {{ $proyecto->curso->Curso }}</li>
                            <li class="list-group-item">Fecha subida: {{ $proyecto->Fecha }}</li>
                            @php
                                $autores = $proyecto->proyectoAlumno->map(function($proyectoAlumno) {
                                    return $proyectoAlumno->usuario->Nombre . ' ' . $proyectoAlumno->usuario->Apellidos;
                                })->implode(', ');
                            @endphp
                            <li class="list-group-item">Autores: {{ $autores }}</li>
                        </ul>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Archivos</h5>
                                    @if($proyecto->ArchivosPriv == 1)
                                        <img src="/storage/imagenes/nodisponible.png" alt="No disponible" style="width: 100px; height: 100px;">
                                    @else
                                        <a href="https://fproyectsarchivos.s3.amazonaws.com/ArchivosPublicos/{{ $proyecto->Archivos }}" download>
                                            <img src="/storage/imagenes/zip.png" alt="Archivo ZIP" style="width: 100px; height: 100px;">
                                        </a>
                                        <p class="mt-2">{{ $proyecto->Archivos }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">Documentación</h5>
                                    @if($proyecto->DocumentacionPriv == 1)
                                        <img src="/storage/imagenes/nodisponible.png" alt="No disponible" style="width: 100px; height: 100px;">
                                    @else
                                        <a href="https://fproyectsarchivos.s3.amazonaws.com/ArchivosPublicos/{{ $proyecto->Documentacion }}" download>
                                            <img src="/storage/imagenes/zip.png" alt="Archivo ZIP" style="width: 100px; height: 100px;">
                                        </a>
                                        <p class="mt-2">{{ $proyecto->Documentacion }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        @if(session()->has('user'))
                            <h5 class="card-title">Valora este proyecto:</h5>
                            <div id="rating-stars" class="starrr" data-rating="5"></div>
                            <p class="mt-2">Valoración actual: <span id="rating-value">{{ $proyecto->MediaValoracion }}</span></p>
                        @else
                            <p class="mt-2">Debes estar <a href="{{ route('login') }}">logueado</a> para valorar este proyecto.</p>
                        @endif
                    </div>
                </div>
                @if(session()->has('user') && $proyecto->proyectoAlumno->pluck('IdUsuario')->contains(session('user.id')))
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('editarProyecto', ['id' => $proyecto->IdProyecto]) }}" class="btn btn-warning btn-sm mr-2">Editar</a>
                        <form action="{{ route('eliminarProyecto', ['id' => $proyecto->IdProyecto]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto?')">Eliminar</button>
                        </form>
                    </div>
                @endif    
            </div>
        </div>
    </div>

    <script>
        @if(session()->has('user'))
            $(document).ready(function() {
                var $ratingStars = $('#rating-stars');
                var currentRating = $ratingStars.data('rating');

                $ratingStars.starrr({
                    rating: currentRating,
                    change: function(e, value) {
                        console.log('Clic en estrella' + value);
                        if (value) {
                            $('#rating-value').text(value);
                            $.ajax({
                                url: '{{ route("guardarValoracion") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    valoracion: value,
                                    proyectoId: {{ $proyecto->IdProyecto }}
                                },
                                success: function(response) {
                                    alert(response.message);
                                    location.reload(); // Recargar para actualizar la valoración media mostrada
                                },
                                error: function(xhr) {
                                    alert('Error al guardar la valoración.');
                                }
                            });
                        }
                    }
                });
            });
        @endif
    </script>
@endsection
