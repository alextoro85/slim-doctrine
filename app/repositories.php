<?php

declare(strict_types=1);

use App\Domain\User\Address\AddressRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\Address\MySqlAddressRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\User\MySqlUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(MySqlUserRepository::class),
        AddressRepository::class => \DI\autowire(MySqlAddressRepository::class),
    ]);
};