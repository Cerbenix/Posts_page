<?php declare(strict_types=1);

namespace App\Controllers\User;

use App\Redirect;
use App\Services\User\Save\SaveUserRequest;
use App\Services\User\Save\SaveUserService;
use App\SessionManager;
use App\Views\View;

class RegisterUserController
{
    private SaveUserService $saveUserService;

    public function __construct(SaveUserService $saveUserService)
    {
        $this->saveUserService = $saveUserService;
    }

    public function register(): View
    {
        return new View('user/register', []);
    }

    public function store(): Redirect
    {
        $request = new SaveUserRequest(
            $_POST['name'],
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['repeatPassword'],
            $_POST['street'],
            $_POST['suite'],
            $_POST['city'],
            $_POST['zipCode'],
            $_POST['phone'],
            $_POST['website'],
            $_POST['companyName'],
            $_POST['companyCatchPhrase'],
            $_POST['companyBusinessServices']
        );

        $response = $this->saveUserService->execute($request);
        $user = $response->getUser();
        SessionManager::set($user->getId());
        return new Redirect('/profile');
    }
}
