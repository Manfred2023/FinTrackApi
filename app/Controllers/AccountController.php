<?php

namespace App\Controllers;

use App\Services\AccountService;
use App\Services\UserService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Reply;
use JetBrains\PhpStorm\NoReturn;

class AccountController
{
    private AccountService $accountService;

    public function __construct()
    {
        $this->accountService = new AccountService();
    }

    /**
     * @throws \Exception
     */
    public function getBalance(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::TOKEN, ], $data);

        $result = $this->accountService->getBalance($data[Constant::TOKEN]);
        Reply::_success($result->toArray());

    }

}