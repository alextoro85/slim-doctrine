<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Address\Address;
use JsonSerializable;

class User implements JsonSerializable
{
    private ?Address $address;

    public function __construct(
        private ?int $id,
        private string $username,
        private string $firstName,
        private string $lastName
    ) {
        $this->id = $id;
        $this->username = strtolower($username);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
        $this->address->setUser($this);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address?->jsonSerialize() ?? null,
        ];
    }
}
