<?php

declare(strict_types=1);

use SearchApi\Application\Settings\Settings;
use SearchApi\Application\Settings\SettingsInterface;
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
                    'name' => 'search-api',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                
                'db' => [
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'username' => 'app',
                    'database' => 'app',
                    'password' => 'pass',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'flags' => [
                        // Turn off persistent connections
                        PDO::ATTR_PERSISTENT => false,
                        // Enable exceptions
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // Emulate prepared statements
                        PDO::ATTR_EMULATE_PREPARES => true,
                        // Set default fetch mode to array
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        // Set character set
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
                    ],
                ],

                'jwt' => [
                    'domain' => 'codingchiefs.com',
                    'algo' => 'HS256',
                    'secret' => 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew2'
                ]
            ]);
        }
    ]);
};
