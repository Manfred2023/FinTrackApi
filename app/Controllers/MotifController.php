<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Motif;
use App\Repositories\MotifRepository;
use App\Services\AccountService;
use App\Services\MotifService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Reply;

class MotifController
{
    private MotifService $motifService;
    private AccountService $accountService;

    public function __construct( )
    {
        $this->motifService = new MotifService();
        $this->accountService = new AccountService();
    }

    /**
     * @throws \Exception
     */
    public function createMotif(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::TOKEN,Constant::NAME,Constant::ACCOUNT,Constant::TYPE, ], $data);

        $account = $this->accountService->getAccountByToken($data[Constant::ACCOUNT]);
        if(!$account instanceof Account) Reply::_error(Constant::ACCOUNT_NOT_FOUND,code: 404);

        $motif = New Motif(null,$data[Constant::TOKEN],$data[Constant::NAME],$data[Constant::TYPE],$account);

        if($motif->getToken() != null){
            $result = $this->motifService->getMotifByToken($motif->getToken());
            if(!$result instanceof Motif)Reply::_error(Constant::MOTIF_NOT_FOUND);

            $result->setName($motif->getName());
            $resultt = $this->motifService->createMotif($result);
            Reply::_success($resultt->toArray());
        } else {
            $resultSearch = $this->motifService->getMotifByName($data[Constant::NAME]);
            if($resultSearch instanceof Motif) Reply::_error(Constant::MOTIF_ALREADY_EXIST,code: 409);
            $result = $this->motifService->createMotif($motif);
            Reply::_success($result->toArray());
        }


    }

    /**
     * @throws \Exception
     */
    public function getAllMotif(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([ Constant::ACCOUNT ], $data);

        $account = $this->accountService->getAccountByToken($data[Constant::ACCOUNT]);
        if(!$account instanceof Account) Reply::_error('account_not_found',code: 404);

        $result = $this->motifService->getAllMotifByAccount($account);
        Reply::_success($result);

    }



}