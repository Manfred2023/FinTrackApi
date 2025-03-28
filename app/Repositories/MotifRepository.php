<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Motif;
use Helper\Constant;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class MotifRepository
{
    protected const TABLE = Constant::MOTIF;

    private AccountRepository $accountRepository;

    public function __construct( )
    {
        $this->accountRepository = new AccountRepository();
    }

    /**
     * @throws SQL
     */
    public function saveMotif(Motif $motif): ?Motif
    {
        $motifBean = ($update = (int)$motif->getId() > 0)
            ? R::loadForUpdate(self::TABLE, $motif->getId())
            : R::dispense(self::TABLE);

        if (!$update) {
            $motifBean->{Constant::TOKEN} =  self::shortToken();
        }
        $motifBean->{Constant::NAME} = $motif->getName();
        $motifBean->{Constant::TYPE} = $motif->getType();
        $motifBean->{Constant::ACCOUNT} = $motif->getAccount()->getId();

        $lastCID = R::store($motifBean);

        return $lastCID > 0 ? self::_toObject(R::load(self::TABLE, $lastCID)) : null;
    }

    static protected function shortToken(): int
    {
        do {
            $nextToken = R::getCell("SELECT MAX(token) FROM motif") ?: 100000;
            $nextToken++;
            $exists = R::count(self::TABLE, 'token = ?', [$nextToken]);
        } while ($exists > 0);

        return $nextToken;
    }

    protected function _toObject(?OODBBean $bean): ?Motif
    {
        if (!$bean instanceof OODBBean)
            return null;
        if (!empty($vars = $bean->export())) {
            return new Motif(
                $vars[Constant::ID] ?? null,
                $vars[Constant::TOKEN] ?? null,
                $vars[Constant::NAME],
                $vars[Constant::TYPE],
                $this->accountRepository->findById($vars[Constant::ACCOUNT])
            );
        }
        return null;
    }

    public function findAllMotifsByAccount(Account $account): ?array
    {
        $accountToken = $account->getId();
        $accountBean = R::findAll(self::TABLE, 'account = ?', [$accountToken]);

        foreach ($accountBean as $bean)

            if ($item = self::_toObject($bean))
                $contacts[] = $item->toArray();
        return $contacts ?? [];


    }


    public function findByToken(string $token): ?Motif
    {
        $motifBean = R::findOne(self::TABLE, 'token = ?', [$token]);

        return ($motifBean) ? self::_toObject($motifBean) : null;
    }
    public function findByName(string $name): ?Motif
    {
        $motifBean = R::findOne(self::TABLE, 'name = ?', [$name]);

        return ($motifBean) ? self::_toObject($motifBean) : null;
    }


}