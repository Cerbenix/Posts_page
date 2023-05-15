<?php declare(strict_types=1);

namespace App\Models;

class UserCompany
{
    private string $name;
    private string $catchPhrase;
    private string $businessServices;

    public function __construct(string $name, string $catchPhrase, string $businessServices)
    {
        $this->name = $name;
        $this->catchPhrase = $catchPhrase;
        $this->businessServices = $businessServices;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBusinessServices(): string
    {
        return $this->businessServices;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }
}
