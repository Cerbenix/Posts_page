<?php declare(strict_types=1);

namespace App\Services\User\Save;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Repositories\User\UserRepository;
use http\Exception\InvalidArgumentException;

class SaveUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(SaveUserRequest $request): SaveUserResponse
    {
        $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);

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
            $password
        );

        $this->userRepository->save($user);

        return new SaveUserResponse($user);
    }

}
