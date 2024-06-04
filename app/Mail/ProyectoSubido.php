<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProyectoSubido extends Mailable
{
    use Queueable, SerializesModels;

    public $proyecto;
    public $archivo;
    public $archivoNombre;
    public $documentacion;
    public $documentacionNombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proyecto, $archivo, $archivoNombre, $documentacion, $documentacionNombre)
    {
        $this->proyecto = $proyecto;
        $this->archivo = $archivo;
        $this->archivoNombre = $archivoNombre;
        $this->documentacion = $documentacion;
        $this->documentacionNombre = $documentacionNombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.proyecto_subido')
                      ->subject('Nuevo Proyecto Subido')
                      ->with([
                          'proyecto' => $this->proyecto,
                          'archivoNombre' => $this->archivoNombre,
                          'documentacionNombre' => $this->documentacionNombre,
                      ]);

        if ($this->archivo) {
            $email->attach($this->archivo->getRealPath(), [
                'as' => $this->archivoNombre,
                'mime' => $this->archivo->getClientMimeType(),
            ]);
        }

        if ($this->documentacion) {
            $email->attach($this->documentacion->getRealPath(), [
                'as' => $this->documentacionNombre,
                'mime' => $this->documentacion->getClientMimeType(),
            ]);
        }

        return $email;
    }
}
