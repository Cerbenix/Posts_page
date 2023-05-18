<?php declare(strict_types=1);

namespace App\Services\User\Index;

use App\Services\ApiClient;

class IndexUserService
{
    private ApiClient $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function execute(IndexUserRequest $request): IndexUserResponse
    {
        $user = $this->apiClient->fetchUser($request->getUserId());
        $userArticles = $this->apiClient->fetchUserArticles($request->getUserId());
        return new IndexUserResponse($user, $userArticles);
    }
}
