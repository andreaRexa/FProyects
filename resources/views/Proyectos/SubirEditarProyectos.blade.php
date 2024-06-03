@extends('layout')

@section('title', 'Subir/Editar Proyecto')

@section('content')
<div class="container">
    <div class="card mt-4">
        <form action="" method="POST" enctype="multipart/form-data" id="form-subir-proyecto">
            @csrf
            @method('PUT')
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre" class="form-control">
                </h5>
                <a href="javascript:history.back()" class="btn btn-primary btn-sm">&laquo; Volver</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">       
                        <img src="" alt="" id="fotoProyecto" name="fotoProyecto" class="card-fluid mt-2" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" id="foto" name="foto" class="form-control-file">
                        <div class="mt-3">
                            <label>Estado del Proyecto:</label><br>
                            <label><input type="radio" name="estado_proyecto" value="publico"> Público</label>&nbsp&nbsp
                            <label><input type="radio" name="estado_proyecto" value="privado"> Privado</label>
                        </div>
                        <div class="mt-3">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-8">
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
                                <option value="{{$curso->IdCurso}}">{{$curso->Curso}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="cursos">Autores</label>
                            <div class="d-flex justify-content-between">
                                <select multiple class="form-control" id="autores" name="autores[]" style="width: 45%; height: 150px;">
                                        
                                </select>
                                <div class="d-flex flex-column justify-content-center mx-2">
                                    <button type="button" id="btn-add-autor" class="btn btn-primary mb-2">&rarr;</button>
                                    <button type="button" id="btn-remove-autor" class="btn btn-primary">&larr;</button>
                                </div>
                                <select multiple class="form-control" id="autoresDisponibles" style="width: 45%; height: 150px;">
                                        
                                </select>
                                </div>
                        </div>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Archivos</h5>
                                    <label><input type="radio" name="estado_archivos" value="publico"> Público</label>&nbsp&nbsp
                                    <label><input type="radio" name="estado_archivos" value="privado"> Privado</label><br>
                                    <img src="/storage/imagenes/zip.png" alt="Archivo ZIP" style="width: 100px; height: 100px;"><br>
                                    <input type="file" id="archivos" name="archivos" class="form-control-file">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">Documentación</h5>
                                    <label><input type="radio" name="estado_documentos" value="publico"> Público</label>&nbsp&nbsp
                                    <label><input type="radio" name="estado_documentos" value="privado"> Privado</label><br>
                                    <img src="/storage/imagenes/zip.png" alt="Archivo ZIP" style="width: 100px; height: 100px;"><br>
                                    <input type="file" id="documentacion" name="documentacion" class="form-control-file">
                                </div>
                            </div>
                        </div>
                        <div class="text-right" style="padding: .75rem 1.25rem;">
                            <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#foto').change(function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#fotoProyecto').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#btn-add-autor').click(function() {
            $('#autores option:selected').appendTo('#autoresDisponibles');
        });

        $('#btn-remove-autor').click(function() {
            $('#autoresDisponibles option:selected').appendTo('#autores');
        });

        $('#btn-guardar').click(function(e) {
            e.preventDefault();
            // Seleccionar todas las opciones disponibles
            $('#autores option').prop('selected', true);
            $('#form-subir-proyecto').submit()
        });

        cargarAutoresDisponibles();

        $('#familia, #ciclo, #curso').change(function() {
            cargarAutoresDisponibles();
            });
        });

        function cargarAutoresDisponibles() {
            var familia = $('#familia').val();
            var ciclo = $('#ciclo').val();
            var curso = $('#curso').val();

            $.ajax({
                url: '{{ route("subirproyectos.obtenerAutores") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Agrega el token CSRF como un campo en los datos
                        familia: familia,
                        ciclo: ciclo,
                        curso: curso
                    },
                success: function(response) {
                    $('#autoresDisponibles').empty();
                    console.log();
                    $.each(response, function(key, value) {
                        $('#autoresDisponibles').append('<option value="' + key + '">' + value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
</script>
@endsection
