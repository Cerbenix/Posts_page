<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\User\Index\IndexUserRequest;
use App\Services\User\Index\IndexUserService;
use App\Views\View;

class UserController
{
    private IndexUserService $indexUserService;

    public function __construct(IndexUserService $indexUserService)
    {
        $this->indexUserService = $indexUserService;
    }

    public function index(array $variables): View
    {
        try {
            $userId = (int)$variables['id'];
            $response = $this->indexUserService->execute(new IndexUserRequest($userId));
            return new View('user', [
                'user' => $response->getUser(),
                'userArticles' => $response->getUserArticles()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
}
