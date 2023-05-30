<?php declare(strict_types=1);

namespace App\Models;

class UserAddress
{
    private ?string $street;
    private ?string $suite;
    private ?string $city;
    private ?string $zipCode;

    public function __construct(
        string $street = null,
        string $suite = null,
        string $city = null,
        string $zipCode = null
    )
    {
        $this->street = $street;
        $this->suite = $suite;
        $this->city = $city;
        $this->zipCode = $zipCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }
}
