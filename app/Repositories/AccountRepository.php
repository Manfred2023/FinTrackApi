<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Helper\Constant;
use Helper\Reply;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

class AccountRepository
{
    protected const TABLE = Constant::ACCOUNT;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function saveUser(Account $account): ?Account
    {
        $accountBean = ($update = (int)$account->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $account->getId())
            : R::dispense(self::TABLE);

        if (!$update) {
            $accountBean->{Constant::TOKEN} =  self::shortToken();
        }
        $accountBean->{Constant::AMOUNT} = $account->getAmount();
        $accountBean->{Constant::USER} = $account->getUser()->getId();

        $lastCID = R::store($accountBean);

        return $lastCID > 0 ? self::_toObject(R::load(self::TABLE, $lastCID)) : null;
    }

    static protected function shortToken(): int
    {
        do {
            $nextToken = R::getCell("SELECT MAX(token) FROM account") ?: 100000;
            $nextToken++;
            $exists = R::count(self::TABLE, 'token = ?', [$nextToken]);
        } while ($exists > 0);

        return $nextToken;
    }

    protected function _toObject(?OODBBean $bean): ?Account
    {
        if (!$bean instanceof OODBBean)
            return null;
        if (!empty($vars = $bean->export())) {

            return new Account(
                $vars[Constant::ID] ?? null,
                $vars[Constant::TOKEN] ?? null,
                $vars[Constant::AMOUNT],
                $this->userRepository->findById( $vars[Constant::ID])
            );
        }
        return null;
    }

    public function getBanlanceByUserToken(string $token)
    {
        try {
            $user = $this->userRepository->findByToken($token);
            if(!$user instanceof  User) Reply::_error(Constant::USER_NOT_FOUND);

            $accountBean = R::findOne(self::TABLE, 'user = ?', [$user->getId()]);

            return ($accountBean) ? self::_toObject($accountBean) : null;
        }catch (Exception $e){
            Reply::_error($e->getMessage());
        }

    }
}