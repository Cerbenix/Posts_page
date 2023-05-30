<?php declare(strict_types=1);

namespace App\Controllers\User;

use App\Services\User\Login\AuthenticationService;
use App\SessionManager;
use App\Views\View;

class AuthenticateUserController
{
    private AuthenticationService $loginService;

    public function __construct(AuthenticationService $loginService)
    {
        $this->loginService = $loginService;
    }
    public function show(): View
    {
        return New View('user/login', []);
    }

    public function login():?View
    {
        $user = $this->loginService->execute($_POST['username'], $_POST['password']);
        if ($user) {
            SessionManager::set($user->getId());
            header('Location: /profile');
            return null;
        } else {
            return New View('user/login', ['message' => 'Incorrect username or password']);
        }
    }

    public function logout():void
    {
        SessionManager::remove();
        header('Location: /');
    }
}
