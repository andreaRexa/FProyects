@extends('layout')

@section('title', 'Editar Proyecto')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Editar Proyecto</h5>
            <a href="javascript:history.back()" class="btn btn-primary btn-sm">&laquo; Volver</a>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <label for="nombre">Nombre del Proyecto:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $proyecto->NombreProyecto }}">
                      
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->FotoProyecto) }}" alt="{{ $proyecto->NombreProyecto }}" class="card-fluid mt-2" style="width: 250px; height: 250px; object-fit: contain;" >
                        <label for="foto">Foto del Proyecto:</label>
                        <input type="file" id="foto" name="foto" class="form-control-file">
                    </div>
                    <div class="col-md-8">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="5">{{ $proyecto->Descripcion }}</textarea>

                        <!-- Agrega los select para Familia, Ciclo y Curso -->
                        <div class="mt-3">
                            <label for="familia">Familia:</label>
                            <select id="familia" name="familia" class="form-control">
                                @foreach($familias as $familia) 
                                    <option value="{{$familia->IdFamilia}}">{{$familia->NombreFamilia}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="ciclo">Ciclo:</label>
                            <select id="ciclo" name="ciclo" class="form-control">
                                @foreach($ciclos as $ciclo) 
                                    <option value="{{$ciclo->IdCiclo}}">{{$ciclo->NombreCiclo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="curso">Curso:</label>
                            <select id="curso" name="curso" class="form-control">
                                @foreach($cursos as $curso) 
                                    <option value="{{$curso->IdCrus}}">{{$curso->Curso}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="archivos">Archivos:</label>
                            <input type="file" id="archivos" name="archivos" class="form-control-file">
                        </div>
                        <div class="mt-3">
                            <label for="documentacion">Documentación:</label>
                            <input type="file" id="documentacion" name="documentacion" class="form-control-file">
                        </div>

                        <!-- Agrega los grupos de radio buttons -->
                        <div class="mt-3">
                            <label>Estado del Proyecto:</label><br>
                            <label><input type="radio" name="estado_proyecto" value="publico"> Público</label>
                            <label><input type="radio" name="estado_proyecto" value="privado"> Privado</label>
                        </div>
                        <div class="mt-3">
                            <label>Estado de Archivos:</label><br>
                            <label><input type="radio" name="estado_archivos" value="publico"> Público</label>
                            <label><input type="radio" name="estado_archivos" value="privado"> Privado</label>
                        </div>
                        <div class="mt-3">
                            <label>Estado de Documentos:</label><br>
                            <label><input type="radio" name="estado_documentos" value="publico"> Público</label>
                            <label><input type="radio" name="estado_documentos" value="privado"> Privado</label>
                        </div>

                        <!-- Botón de envío del formulario -->
                        <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
