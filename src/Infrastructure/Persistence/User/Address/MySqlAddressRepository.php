<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User\Address;

use App\Domain\User\Address\Address;
use App\Domain\User\Address\AddressRepository;
use Doctrine\ORM\EntityManager;

class MySqlAddressRepository implements AddressRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function save(Address $address): void
    {
        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }
}
