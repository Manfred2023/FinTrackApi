<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Contact;
use Helper\Constant;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

class ContactRepository
{
    protected const TABLE = Constant::CONTACT;

    private AccountRepository $accountRepository;

    public function __construct(  )
    {
        $this->accountRepository = New AccountRepository;
    }
    public function saveUser(Contact $account): ?Contact
    {
        $contactBean = ($update = (int)$account->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $account->getId())
            : R::dispense(self::TABLE);

        if (!$update) {
            $contactBean->{Constant::TOKEN} =  self::shortToken();
        }
        $contactBean->{Constant::NAME} = $account->getName();
        $contactBean->{Constant::MOBILE} = $account->getMobile();
        $contactBean->{Constant::LOCATION} = $account->getLocation();
        $contactBean->{Constant::ACCOUNT} = $account->getAccount()->getId();

        $lastCID = R::store($contactBean);

        return $lastCID > 0 ? self::_toObject(R::load(self::TABLE, $lastCID)) : null;
    }
    static protected function shortToken(): int
    {
        do {
            $nextToken = R::getCell("SELECT MAX(token) FROM contact") ?: 100000;
            $nextToken++;
            $exists = R::count(self::TABLE, 'token = ?', [$nextToken]);
        } while ($exists > 0);

        return $nextToken;
    }

    protected function _toObject(?OODBBean $bean): ?Contact
    {
        if (!$bean instanceof OODBBean)
            return null;

        if (!empty($vars = $bean->export())) {
            return new Contact(
                $vars[Constant::ID] ?? null,
                $vars[Constant::TOKEN] ?? null,
                $vars[Constant::NAME],
                $vars[Constant::MOBILE],
                $vars[Constant::LOCATION],
                $this->accountRepository->findById( $vars[Constant::ACCOUNT])
            );
        }
        return null;
    }
    public function findById(string $id): ?Contact
    {
        $userBean = R::findOne(self::TABLE, 'id = ?', [$id]);

        return ($userBean) ? self::_toObject($userBean) : null;
    }
    public function findByToken(string $token): ?Contact
    {
        $accountBean = R::findOne(self::TABLE, 'token = ?', [$token]);

        return ($accountBean) ? self::_toObject($accountBean) : null;
    }
    public function findContactByMobile(string $mobile): ?Contact
    {
        $accountBean = R::findOne(self::TABLE, 'mobile = ?', [$mobile]);

        return ($accountBean) ? self::_toObject($accountBean) : null;
    }
    public function findAllContactByAccount(Account $account): ?array
    {
        $accountToken = $account->getId();
        $accountBean = R::findAll(self::TABLE, 'account = ?', [$accountToken]);

        foreach ($accountBean as $bean)
            if ($item = self::_toObject($bean))
                $contacts[] = $item->toArray();
        return $contacts ?? [];


    }

}