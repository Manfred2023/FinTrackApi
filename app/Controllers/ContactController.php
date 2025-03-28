<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Services\AccountService;
use App\Services\ContactService;
use Helper\Constant;
use Helper\Criteria;
use Helper\Reply;

class ContactController
{
    private ContactService $contactService;
    private AccountService $accountService;

    /**
     * save contact
     */
    public function __construct( )
    {
        $this->contactService = new ContactService();
        $this->accountService = new AccountService();
    }

    /**
     * @throws \Exception
     */
    public function saveContact()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::TOKEN,Constant::NAME,Constant::MOBILE,Constant::LOCATION,Constant::ACCOUNT ], $data);

        $account = $this->accountService->getAccountByToken($data[Constant::ACCOUNT]);
        if(!$account instanceof Account) Reply::_error(Constant::ACCOUNT_NOT_FOUND,code: 404);

        $contact = new Contact(null, $data[Constant::TOKEN], $data[Constant::NAME],$data[Constant::MOBILE],$data[Constant::LOCATION],$account);

        $contact->validateContact();

        if($contact->getToken() != null){
            $checkContact = $this->contactService->getContactByToken($contact);
            if(!$checkContact instanceof  Contact) Reply::_error(Constant::ACCOUNT_NOT_FOUND);
            $checkContact ->setName($contact->getName());
            $checkContact ->setLocation($contact->getLocation());
            $checkContact ->setMobile($contact->getMobile());
            $result = $this->contactService->saveContact($checkContact);
            Reply::_success($result->toArray());
        } else {
            $checkContact = $this->contactService->getContactByMobile($contact->getMobile());
            if($checkContact instanceof Contact) Reply::_error(Constant::CONTACT_ALREADY_EXIST,code: 409);
            $result = $this->contactService->saveContact($contact);
            Reply::_success($result->toArray());
        }


    }

    /**
     * @throws \Exception
     */
    public function getAllContactsByAccount()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        Criteria::_formRequiredCheck([Constant::ACCOUNT], $data);

        $result = $this->accountService->getAccountByToken($data[Constant::ACCOUNT]);
        if(!$result instanceof Account) Reply::_error(Constant::ACCOUNT_NOT_FOUND);
        $result = $this->contactService->getAllContactByAccount($result);
        Reply::_success($result);
    }

}