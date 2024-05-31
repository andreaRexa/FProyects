<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Código de recuperación de contraseña')
                    ->html($this->buildHtmlContent());
    }

    private function buildHtmlContent()
    {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Recuperación de Contraseña</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        background-color: #f9f9f9;
                    }
                    .header {
                        text-align: center;
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 0;
                        border-radius: 10px 10px 0 0;
                    }
                    .content {
                        padding: 20px;
                    }
                    .code {
                        font-size: 24px;
                        font-weight: bold;
                        text-align: center;
                        margin: 20px 0;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        color: #555;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Recuperación de Contraseña</h1>
                    </div>
                    <div class='content'>
                        <p>Hola,</p>
                        <p>Has solicitado recuperar tu contraseña. Usa el siguiente código para restablecerla:</p>
                        <div class='code'>{$this->code}</div>
                        <p>Si no solicitaste un restablecimiento de contraseña, puedes ignorar este correo electrónico.</p>
                        <p>Gracias,</p>
                        <p>El equipo de FProjects</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; " . date('Y') . " FProjects. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }
}
