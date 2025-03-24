<?php

namespace App\Services;

use App\Models\Account;
use App\Repositories\AccountRepository;

class AccountService
{
    private AccountRepository $accountRepository;

    public function __construct()
    {
        $this->accountRepository = new AccountRepository();
    }

    public function createAccount (Account $account):?Account
    {
        return $this->accountRepository->saveUser($account);
    }
    public function getBalance(string $token): ?Account
    {
        return $this->accountRepository->getBanlanceByUserToken($token);
    }
}