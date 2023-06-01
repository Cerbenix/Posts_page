<?php declare(strict_types=1);

namespace App\Controllers\User;

use App\Redirect;
use App\Services\User\Index\IndexUserRequest;
use App\Services\User\Index\IndexUserService;
use App\Services\User\Save\SaveUserRequest;
use App\Services\User\Update\UpdateUserRequest;
use App\Services\User\Update\UpdateUserService;

use App\SessionManager;
use App\Views\View;

class UpdateUserController
{
    private UpdateUserService $updateUserService;
    private IndexUserService $indexUserService;

    public function __construct(
        UpdateUserService $updateUserService,
        IndexUserService  $indexUserService
    )
    {
        $this->updateUserService = $updateUserService;
        $this->indexUserService = $indexUserService;
    }

    public function edit(): View
    {
        $userId = SessionManager::get();
        $response = $this->indexUserService->execute(new IndexUserRequest($userId));
        return new View('user/update', ['user' => $response->getUser()]);
    }
    public function update():Redirect
    {
        $request = new UpdateUserRequest(
            SessionManager::get(),
            $_POST['name'],
            $_POST['username'],
            $_POST['email'],
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

        $this->updateUserService->execute($request);

        return new Redirect('/profile');
    }
}
