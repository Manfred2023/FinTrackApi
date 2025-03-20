<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Helper;
use Helper\Reply;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @throws \Exception
     */
    public function saveUser(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([
            Constant::TOKEN,
            Constant::NICKNAME,
            Constant::EMAIL,
            Constant::MOBILE,
            Constant::PIN,
        ], $data);

        $this->validateUserData($data);

        $user = new User(null, $data[Constant::TOKEN],$data[Constant::NICKNAME],$data[Constant::MOBILE],$data[Constant::EMAIL],$data[Constant::PIN],false,false);


        if ($user->getToken()) {
            $existingUser = $this->userService->getUserByToken((int)$user->getToken());

            if (!$existingUser instanceof User) {
                Reply::_error('user_not_found', 404);
            }

            $existingUser->setNickname($user->getNickname());
            $existingUser->setMobile($user->getMobile());
            $existingUser->setEmail($user->getEmail());
            $existingUser->setPin($user->getPin());

            $userUpdate = $this->userService->saveUser($existingUser);
            Reply::_success($userUpdate->toArray());
        } else {
            $savedUser = $this->userService->saveUser($user);
            Reply::_success($savedUser->toArray());
        }
    }

    /**
     * @throws \Exception
     */
    public function authUser(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::EMAIL, Constant::MOBILE, Constant::PIN], $data);

        $user = $this->getUserByEmailOrMobile($data);

        if (!$user || $user->getPin() !== $data[Constant::PIN]) {
            Reply::_error('auth_failed', 401);
        }

        Reply::_success('auth_success');
    }

    /**
     * Valide les données utilisateur.
     *
     * @param array $data
     * @throws \Exception
     */
    private function validateUserData(array $data): void
    {
        if (!Helper::isEmailFormatValid($data[Constant::EMAIL])) {
            Reply::_error('invalid_email', 400);
        }

        if (!Helper::isCameroonianPhoneNumber($data[Constant::MOBILE])) {
            Reply::_error('invalid_mobile', 400);
        }
    }

    /**
     * Récupère l'utilisateur par email ou mobile.
     *
     * @param array $data
     * @return User|null
     */
    private function getUserByEmailOrMobile(array $data): ?User
    {
        if (!empty($data[Constant::MOBILE])) {
            if (!Helper::isCameroonianPhoneNumber($data[Constant::MOBILE])) {
                Reply::_error('invalid_mobile', 400);
            }
            return $this->userService->getUserByMobileOrEmail($data[Constant::MOBILE], null);
        }

        if (!Helper::isEmailFormatValid($data[Constant::EMAIL])) {
            Reply::_error('invalid_email', 400);
        }

        return $this->userService->getUserByMobileOrEmail(null, $data[Constant::EMAIL]);
    }
}
