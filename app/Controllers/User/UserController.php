<?php declare(strict_types=1);

namespace App\Controllers\User;

use App\Services\User\Index\IndexUserRequest;
use App\Services\User\Index\IndexUserService;
use App\SessionManager;
use App\Views\View;

class UserController
{
    private IndexUserService $indexUserService;

    public function __construct(IndexUserService $indexUserService)
    {
        $this->indexUserService = $indexUserService;
    }

    public function show(array $variables): View
    {
        try {
            $userId = (int)$variables['id'];
            $response = $this->indexUserService->execute(new IndexUserRequest($userId));
            return new View('user/show', [
                'user' => $response->getUser(),
                'userArticles' => $response->getUserArticles()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
    public function profile():View
    {
        try {
            $userId = SessionManager::get();
            $response = $this->indexUserService->execute(new IndexUserRequest($userId));
            return new View('user/profile', [
                'user' => $response->getUser(),
                'userArticles' => $response->getUserArticles()
            ]);
        }catch (\Exception $exception){
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
}
