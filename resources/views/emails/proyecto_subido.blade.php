<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Proyecto Subido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .email-content {
            margin: 20px 0;
        }
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Nuevo Proyecto Subido</h1>
        </div>
        <div class="email-content">
            <p>Hola,</p>
            <p>Se ha subido un nuevo proyecto. Aquí están los detalles:</p>
            <ul>
                <li><strong>Nombre del Proyecto:</strong> {{ $proyecto->NombreProyecto }}</li>
                <li><strong>Descripción:</strong> {{ $proyecto->Descripcion }}</li>
                <li><strong>Archivo:</strong> {{ $archivoNombre }}</li>
                <li><strong>Documentación:</strong> {{ $documentacionNombre }}</li>
            </ul>
        </div>
        <div class="email-footer">
            <p>Este es un mensaje generado automáticamente. Por favor, no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>
