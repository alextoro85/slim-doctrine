<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $doctrineSettings = $settings->get('doctrine');

            $config = ORMSetup::createXMLMetadataConfiguration(
                $doctrineSettings['xml_mapping_dir'],
                $doctrineSettings['dev_mode']
            );

            $connection = DriverManager::getConnection($doctrineSettings['connection'], $config);

            return new EntityManager($connection, $config);
        },
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
    ]);
};