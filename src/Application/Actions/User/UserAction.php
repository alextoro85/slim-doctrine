<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Address\AddressRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected UserRepository $userRepository,
        protected AddressRepository $addressRepository
    ) {
        parent::__construct($logger);
    }
}
