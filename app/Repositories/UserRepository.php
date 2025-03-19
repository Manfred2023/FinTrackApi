<?php

namespace App\Repositories;

use App\Models\User;
use Helper\Reply;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class UserRepository
{
    /**
     * @throws SQL
     */
    public function create(User $user): ?User
    {
        $userBean = R::dispense('user');
        $userBean->token = self::shortToken();
        $userBean->nickname = $user->getNickname();
        $userBean->email = $user->getEmail();
        $userBean->mobile = $user->getMobile();
        $userBean->pin = $user->getPin();
        $userBean->admin = $user->getAdmin();
        $userBean->blocked = $user->getBlocked();

        $lastID = R::store($userBean);

        return $lastID > 0 ? self::_toObject($lastID) : null;
    }

    static protected function shortToken(): int
    {
        do {
            $nextToken = R::getCell("SELECT MAX(token) FROM user") ?: 100000;
            $nextToken++;
            $exists = R::count('user', 'token = ?', [$nextToken]);
        } while ($exists > 0); // S'assure que le token est unique

        return $nextToken;
    }

    protected static function _toObject(?OODBBean $bean): ?User
    {
        $bean = R::load('user', $id);

        if ($bean->id === 0) {
            return null;
        }

        $vars = $bean->export();

        return new User(
            $vars['id'],
            $vars['token'] ?? null,
            $vars['nickname'],
            $vars['mobile'] ?? null,
            $vars['email'],
            $vars['pin'],
            $vars['admin'],
            $vars['blocked']
        );
    }


    public function findById(int $id): ?User
    {
        $userBean = R::findOne('user', 'id = ?', [$id]);
        if ($userBean) {
            return new User(
                null,
                null,
                $userBean->nickname,
                $userBean->mobile,
                $userBean->email,
                $userBean->pin,
                $userBean->admin,
                $userBean->blocked
            );
        }
        return null;
    }
    public function findByToken(int $token): ?User
    {
        $userBean = R::findOne('user', 'token = ?', [$token]);
        $result = self::_toObject($userBean)
        if ($userBean) {
            return new User(
                null,
                null,
                $userBean->nickname,
                $userBean->mobile,
                $userBean->email,
                $userBean->pin,
                $userBean->admin,
                $userBean->blocked
            );
        }
        return null;
    }

    public function findAll(): array
    {

        return R::findAll('users');
    }

    public function update(int $id, array $data): bool
    {
        $user = R::load('users', $id);
        if ($user->id) {
            foreach ($data as $key => $value) {
                if ($key === 'pin') {
                    $user->$key = password_hash($value, PASSWORD_DEFAULT);
                } else {
                    $user->$key = $value;
                }
            }
            R::store($user);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $user = R::load('users', $id);
        if ($user->id) {
            R::trash($user);
            return true;
        }
        return false;
    }
}
