<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    'dev_mode' => true,
                    'cache_dir' => __DIR__ . '/../var/doctrine',
                    'metadata_dirs' => [__DIR__ . '/../src/Domain'],
                    'xml_mapping_dir' => [__DIR__ . '/../app/doctrine'],
                    'connection' => [
                        'driver' => 'pdo_mysql',
                        'host' => 'localhost',
                        'port' => 3306,
                        'dbname' => 'slim_doctrine',
                        'user' => 'root',
                        'password' => 'toor1234',
                        'charset' => 'utf8mb4'
                    ]
                ]
            ]);
        }
    ]);
};