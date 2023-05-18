<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\User\Index\IndexUserRequest;
use App\Services\User\Index\IndexUserService;
use App\Views\View;

class UserController
{
    public function index(array $variables): View
    {
        try {
            $userId = (int)$variables['id'];
            $service = new IndexUserService();
            $response = $service->execute(new IndexUserRequest($userId));
            return new View('user', [
                'user' => $response->getUser(),
                'userArticles' => $response->getUserArticles()
            ]);
        } catch (\Exception $exception) {
            return new View('error', ['message' => $exception->getMessage()]);
        }
    }
}
