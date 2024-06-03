<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3TestController extends Controller
{
    public function uploadTestFile()
    {
        try {
            // Archivo de prueba
            $filePath = storage_path('/imagenes/zip.png');
            $fileContent = 'Este es un archivo de prueba para subir a S3';
            file_put_contents($filePath, $fileContent);

            // Nombre del archivo en S3
            $s3FileName = 'ArchivosPublicos/test-file.txt';

            // Subir archivo a S3
            $uploadSuccess = Storage::disk('s3')->put($s3FileName, file_get_contents($filePath));

            if ($uploadSuccess) {
                return response()->json(['success' => 'Archivo subido correctamente a S3']);
            } else {
                throw new \Exception('Error al subir archivo a S3');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
