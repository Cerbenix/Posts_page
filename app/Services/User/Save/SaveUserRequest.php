<?php declare(strict_types=1);

namespace App\Services\User\Save;

class SaveUserRequest
{
    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private ?string $street;
    private ?string $suite;
    private ?string $city;
    private ?string $zipCode;
    private ?string $phone;
    private ?string $website;
    private ?string $companyName;
    private ?string $companyCatchPhrase;
    private ?string $companyBusinessServices;


    public function __construct(
        string $name,
        string $username,
        string $email,
        string $password,
        string $street = null,
        string $suite = null,
        string $city = null,
        string $zipCode = null,
        string $phone = null,
        string $website = null,
        string $companyName = null,
        string $companyCatchPhrase = null,
        string $companyBusinessServices = null
    )
    {

        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->street = $street;
        $this->suite = $suite;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->phone = $phone;
        $this->website = $website;
        $this->companyName = $companyName;
        $this->companyCatchPhrase = $companyCatchPhrase;
        $this->companyBusinessServices = $companyBusinessServices;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getCompanyBusinessServices(): ?string
    {
        return $this->companyBusinessServices;
    }

    public function getCompanyCatchPhrase(): ?string
    {
        return $this->companyCatchPhrase;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }
}
