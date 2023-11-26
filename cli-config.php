<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use DI\ContainerBuilder;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

ConsoleRunner::run(
    new SingleManagerProvider($container->get(EntityManager::class)),
    $commands
);