<?php

namespace App\Services;

use App\Models\User;
use Helper\Reply;
use App\Repositories\UserRepository;
use RedBeanPHP\RedException\SQL;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws SQL
     */
    public function saveUser(User $user): User
    {
        return $this->userRepository->saveUser($user);
    }
    public  function getUserByToken(int $token)
    {
        return $this->userRepository->findByToken($token);
    }
    public  function getUserByMobileOrEmail(?int $mobile,?string $email)
    {
        return $this->userRepository->getUserByMobileOrEmail($mobile,$email);
    }



}
