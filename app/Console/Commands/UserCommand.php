<?php declare(strict_types=1);

namespace App\Console\Commands;


use App\Services\User\Index\IndexUserRequest;
use App\Services\User\Index\IndexUserService;

class UserCommand
{
    private IndexUserService $userService;

    public function __construct(IndexUserService $indexUserService)
    {
        $this->userService = $indexUserService;
    }

    public function execute(int $userId): void
    {
        $response = $this->userService->execute(new IndexUserRequest($userId));
        $user = $response->getUser();

        echo "User Details:\n";
        echo "[ID]: " . $user->getId() . "\n";
        echo "[Name]: " . $user->getName() . "\n";
        echo "[Username]: " . $user->getUsername() . "\n";
        echo "[Email]: " . $user->getEmail() . "\n";
        echo "[Phone]: " . $user->getPhone() . "\n";
        echo "[Website]: " . $user->getWebsite() . "\n";
        echo "[City]: " . $user->getAddress()->getCity() . "\n";
        echo "[Street]: " . $user->getAddress()->getStreet() . "\n";
        echo "[Suite]: " . $user->getAddress()->getSuite() . "\n";
        echo "[Zip Code]: " . $user->getAddress()->getZipCode() . "\n";
        echo "[Company Name]: " . $user->getCompany()->getName() . "\n";
        echo "[Business Services]: " . $user->getCompany()->getBusinessServices() . "\n";
        echo "[Company Catch Phrase]: " . $user->getCompany()->getCatchPhrase() . "\n";

        echo "++++++++++++++++++++++++++++++++++++++++++++++\n";
        echo "User Articles\n";
        foreach ($response->getUserArticles() as $article) {
            echo "[Title]: " . $article->getTitle() . "\n";
            echo "[Body]: " . $article->getBody() . "\n";
            echo "++++++++++++++++++++++++++++++++++++++++++++++\n";
        }
    }
}