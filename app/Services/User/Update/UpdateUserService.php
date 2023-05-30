<?php declare(strict_types=1);

namespace App\Services\User\Update;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Repositories\User\UserRepository;


class UpdateUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(UpdateUserRequest $request): void
    {
        $user = New User(
            $request->getName(),
            $request->getUsername(),
            $request->getEmail(),
            New UserAddress(
                $request->getStreet(),
                $request->getSuite(),
                $request->getCity(),
                $request->getZipCode()
            ),
            $request->getPhone(),
            $request->getWebsite(),
            New UserCompany(
                $request->getCompanyName(),
                $request->getCompanyCatchPhrase(),
                $request->getCompanyBusinessServices()
            ),
            $request->getId()
        );

        $this->userRepository->update($user);
    }
}
