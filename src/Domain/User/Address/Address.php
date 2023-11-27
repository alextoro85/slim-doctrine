<?php

declare(strict_types=1);

namespace App\Domain\User\Address;

use App\Domain\User\User;
use JsonSerializable;

class Address implements JsonSerializable
{
    private ?User $user;

    public function __construct(
        private ?int $id,
        private string $street,
        private string $city,
        private string $country,
        private string $zipCode
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'country' => $this->country,
            'zipCode' => $this->zipCode,
        ];
    }
}
