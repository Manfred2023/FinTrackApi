<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Contact;
use App\Repositories\AccountRepository;
use App\Repositories\ContactRepository;

class ContactService
{
    private ContactRepository $contactRepository;


    public function __construct()
    {
        $this->contactRepository = New ContactRepository();
    }

    public function saveContact(Contact $contact): Contact
    {
        return $this->contactRepository->saveUser($contact);
    }
    public function getContactByToken(Contact $contact): ?Contact
    {
        return $this->contactRepository->findByToken($contact->getToken());
    }
    public function getAllContactByAccount(Account $account): ?array
    {
        return $this->contactRepository->findAllContactByAccount($account);
    }
    public function getContactByMobile(string $mobile): ?Contact
    {
        return $this->contactRepository->findContactByMobile($mobile);
    }

}