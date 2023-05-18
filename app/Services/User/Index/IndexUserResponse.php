<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Models\User;
use App\Services\ApiClient;

class IndexUserResponse
{
    private User $user;
    private array $userArticles;

    public function __construct(User $user, array $userArticles)
    {

        $this->user = $user;
        $this->userArticles = $userArticles;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserArticles(): array
    {
        return $this->userArticles;
    }
}