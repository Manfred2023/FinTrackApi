<?php

namespace App\Services;

use App\Models\User;
use Helper\Reply;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function createUser(?string $token,string $nickname, string $email, string $mobile, string $pin ): User
    {
        $user = new User(null,$token, $nickname,$mobile, $email,  $pin,false,false);

        return $this->userRepository->create($user);
    }


}
