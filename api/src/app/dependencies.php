<?php

declare(strict_types=1);

use SearchApi\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $databaseSettings = $settings->get('db');
        
            $host = $databaseSettings['host'];
            $dbname = $databaseSettings['database'];
            $username = $databaseSettings['username'];
            $password = $databaseSettings['password'];
            $charset = $databaseSettings['charset'];
            $flags = $databaseSettings['flags'];
        
            return new PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $username,
                $password,
                $flags
            );
        },
    ]);
};
