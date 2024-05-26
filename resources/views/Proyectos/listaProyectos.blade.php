<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proyectos</title>
</head>
<body>
    <h1>Listado de Proyectos</h1>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ciclo</th>
                <th>Curso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $proyecto)
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,{{ base64_encode($proyecto->foto) }}" alt="{{ $proyecto->nombre }}" style="width: 100px;">
                    </td>
                    <td>{{ $proyecto->nombre }}</td>
                    <td>{{ $proyecto->descripcion }}</td>
                    <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->ciclo->nombre }}</td>
                    <td>{{ $proyecto->proyectoAlumno->usuario->alumnoCiclo->FechaCurso }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
