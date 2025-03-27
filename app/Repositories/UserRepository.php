<?php

namespace App\Repositories;

use App\Models\User;
use Helper\Constant;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class UserRepository
{
    protected const TABLE = Constant::USER;
    /**
     * @throws SQL
     */
    public function saveUser(User $user): ?User
    {
        $userBean = ($update = (int)$user->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $user->getId())
            : R::dispense(self::TABLE);

        if (!$update) {
            $userBean->{Constant::TOKEN} =  self::shortToken();
        }
        $userBean->{Constant::NICKNAME} = $user->getNickname();
        $userBean->{Constant::EMAIL} = $user->getEmail();
        $userBean->{Constant::MOBILE} = $user->getMobile();
        $userBean->{Constant::PIN} = $user->getPin();
        $userBean->{Constant::ADMIN} = $user->getAdmin();
        $userBean->{Constant::BLOCKED} = $user->getBlocked();

        $lastCID = R::store($userBean);

        return $lastCID > 0 ? self::_toObject(R::load(self::TABLE, $lastCID)) : null;
    }

    static protected function shortToken(): int
    {
        do {
            $nextToken = R::getCell("SELECT MAX(token) FROM user") ?: 100000;
            $nextToken++;
            $exists = R::count(self::TABLE, 'token = ?', [$nextToken]);
        } while ($exists > 0);

        return $nextToken;
    }

    protected static function _toObject(?OODBBean $bean): ?User
    {
        if (!$bean instanceof OODBBean)
            return null;
        if (!empty($vars = $bean->export())) {
            return new User(
                $vars[Constant::ID] ?? null,
                $vars[Constant::TOKEN] ?? null,
                $vars[Constant::NICKNAME] ,
                $vars[Constant::MOBILE] ,
                $vars[Constant::EMAIL],
                $vars[Constant::PIN],
                $vars[Constant::ADMIN] ?? null,
                $vars[Constant::BLOCKED] ?? null
            );
        }
        return null;



    }

    public function findByToken(string $token): ?User
    {
        $userBean = R::findOne(self::TABLE, 'token = ?', [$token]);

        return ($userBean) ? self::_toObject($userBean) : null;
    }
    public function findById(string $id): ?User
    {
        $userBean = R::findOne(self::TABLE, 'id = ?', [$id]);

        return ($userBean) ? self::_toObject($userBean) : null;
    }
    public function getUserByMobileOrEmail(?int $mobile,?string $email): ?User
    {
        if($mobile != null){
            $userBean = R::findOne(self::TABLE, 'mobile = ?', [$mobile]);
        }else{
            $userBean = R::findOne(self::TABLE, 'email = ?', [$email]);
        }
        return ($userBean) ? self::_toObject($userBean) : null;

    }
    public function delete(int $id): bool
    {
        $user = R::load(self::TABLE, $id);
        if ($user->getID()) {
            R::trash($user);
            return true;
        }
        return false;
    }
}
