<?php declare(strict_types=1);

namespace App\Models;

class User
{
    private ?int $id;
    private string $name;
    private string $username;
    private string $email;
    private ?UserAddress $address;
    private ?string $phone;
    private ?string $website;
    private ?UserCompany $company;
    private ?string $password;

    public function __construct(
        string       $name,
        string       $username,
        string       $email,
        ?UserAddress $address = null,
        ?string      $phone = null,
        ?string      $website = null,
        ?UserCompany $company = null,
        ?string      $password = null,
        ?int         $id = null

    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->address = $address;
        $this->phone = $phone;
        $this->website = $website;
        $this->company = $company;
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): ?UserAddress
    {
        return $this->address;
    }

    public function getCompany(): ?UserCompany
    {
        return $this->company;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
