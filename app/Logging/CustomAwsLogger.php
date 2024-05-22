<?php

namespace App\Logging;

use Aws\Symfony\AwsBundle\Logger\AwsLogger;
use Monolog\Logger;

class CustomAwsLogger
{
    public function __invoke(array $config)
    {
        $awsLogger = new AwsLogger(new Logger('aws'), [
            'region' => 'us-east-1', // Reemplaza 'tu-region' con la región de AWS
            'version' => 'latest',
            'http' => [
                'verify' => false, // Opcional: desactiva la verificación SSL si es necesario
            ],
        ]);

        return $awsLogger;
    }
}
