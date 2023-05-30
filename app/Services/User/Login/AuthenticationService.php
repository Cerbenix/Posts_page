<?php declare(strict_types=1);

namespace App\Services\User\Login;

use App\Models\User;
use App\Repositories\User\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(string $username, string $password): ?User
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }
}
