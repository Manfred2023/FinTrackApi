<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Services\AccountService;
use App\Services\UserService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Helper;
use Helper\Reply;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\RedException\SQL;

class UserController
{
    private UserService $userService;
    private AccountService $accountService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->accountService = new AccountService();
    }

    /**
     * @return void
     * @throws SQL
     * @throws \Exception
     */
    #[NoReturn] public function saveUser(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([
            Constant::TOKEN,
            Constant::NICKNAME,
            Constant::EMAIL,
            Constant::MOBILE,
            Constant::PIN,
        ], $data);


        $user = new User(null, $data[Constant::TOKEN],$data[Constant::NICKNAME],$data[Constant::MOBILE],$data[Constant::EMAIL],$data[Constant::PIN],false,false);

        User::validateUser($user);

        if ($user->getToken()) {
            $existingUser = $this->userService->getUserByToken((int)$user->getToken());

            if (!$existingUser instanceof User) {
                Reply::_error(Constant::USER_NOT_FOUND, 404);
            }

            $existingUser->setNickname($user->getNickname());
            $existingUser->setPin($user->getPin());

            $userUpdate = $this->userService->saveUser($existingUser);
            Reply::_success($userUpdate->toArray());
        } else {
            $checkUserByMobile = $this->userService->getUserByMobileOrEmail($user->getMobile(), null);
            if($checkUserByMobile instanceof User) Reply::_error(Constant::MOBILE_ALREADY_USED);

            $checkUserByEmail = $this->userService->getUserByMobileOrEmail(null,  $user->getEmail());
            if($checkUserByEmail instanceof User) Reply::_error(Constant::EMAIL_ALREADY_USED);

            $savedUser = $this->userService->saveUser($user);
            $account = new Account(null,null,0,$savedUser);
            $this->accountService->createAccount($account);
            Reply::_success($savedUser->toArray(),code: 201);
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[NoReturn] public function authUser(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::EMAIL, Constant::MOBILE, Constant::PIN], $data);

        if($data[Constant::EMAIL] != null){
            $user = $this->userService->getUserByMobileOrEmail(null, $data[Constant::EMAIL]);
        } else{
            $user = $this->userService->getUserByMobileOrEmail($data[Constant::MOBILE], null);
        }


        if (!$user || $user->getPin() !== $data[Constant::PIN]) {
            Reply::_error(Constant::AUTHENTICATION_FAILED, 401);
        }

        Reply::_success($user->toArray());
    }


}
