<?php

declare(strict_types=1);

namespace App\Domain\User\Address;

interface AddressRepository
{
    /**
     * @param Address $address
     */
    public function save(Address $address): void;
}
