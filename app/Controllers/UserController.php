<?php

namespace App\Controllers;
use App\Models\User;
use App\Services\UserService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Reply;
use JetBrains\PhpStorm\NoReturn;

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

        Criteria::_formRequiredCheck([Constant::TOKEN,Constant::NICKNAME, Constant::EMAIL, Constant::MOBILE, Constant::PIN, ], $data);

        $userCheck = new User(null, $data[Constant::TOKEN],$data[Constant::NICKNAME],$data[Constant::MOBILE],$data[Constant::EMAIL],$data[Constant::PIN],false,false);
        if($userCheck->getToken() != null ){
            $result = $this->userService->getUserByToken((int)$userCheck->getToken());
            if(!$result instanceof User) Reply::_error('user_not_found',code: 404);

            $result->setNickname($userCheck->getNickname());
            $result->setMobile($userCheck->getMobile());
            $result->setEmail($userCheck->getEmail());

            $userUpdate = $this->userService->saveUser($result);
            Reply::_success($userUpdate->toArray());

        }else{
            $userId = $this->userService->saveUser($userCheck);
            Reply::_success($userId->toArray());
        }

    }
}
