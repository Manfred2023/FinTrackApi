<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Motif;
use App\Repositories\MotifRepository;

class MotifService
{
    private MotifRepository $repository;

    /**
     * @param MotifRepository $repository
     */
    public function __construct( )
    {
        $this->repository = new MotifRepository();
    }
    public function createMotif(Motif $motif):?Motif
    {
        return $this->repository->saveMotif($motif);
    }

    public  function getAllMotifByAccount(Account $account): ?array
    {
        return $this->repository->findAllMotifsByAccount($account);
    }
    public  function getMotifByToken(string $token): ?Motif
    {
        return $this->repository->findByToken($token);
    }
    public  function getMotifByName(string $name): ?Motif
    {
        return $this->repository->findByName($name);
    }

}