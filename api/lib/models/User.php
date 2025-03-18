<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */

class User extends UserDBA
{
    private ?int $id;
    private ?int $token;
    private ?string $email;
    private ?string $mobile;
    private int $pin;
    private ?Contact $contact;
    private ?Profile $profile;
    private ?bool $isdeleted;
    private ?bool $isblocked;
    private ?User $createdby;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param string|null $email
     * @param string|null $mobile
     * @param int $pin
     * @param Contact|null $contact
     * @param Profile|null $profile
     * @param bool|null $isdeleted
     * @param bool|null $isblocked
     * @param User|null $createdby
     */
    public function __construct(?int $id, ?int $token, ?string $email, ?string $mobile, int $pin, ?Contact $contact, ?Profile $profile, ?bool $isdeleted, ?bool $isblocked, ?User $createdby)
    {
        $this->id = $id;
        $this->token = $token;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->pin = $pin;
        $this->contact = $contact;
        $this->profile = $profile;
        $this->isdeleted = $isdeleted;
        $this->isblocked = $isblocked;
        $this->createdby = $createdby;
    }

    public function getIsdeleted(): ?bool
    {
        return $this->isdeleted;
    }

    public function setIsdeleted(?bool $isdeleted): void
    {
        $this->isdeleted = $isdeleted;
    }

    public function getIsblocked(): ?bool
    {
        return $this->isblocked;
    }

    public function setIsblocked(?bool $isblocked): void
    {
        $this->isblocked = $isblocked;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getToken(): ?int
    {
        return $this->token;
    }

    public function setToken(?int $token): void
    {
        $this->token = $token;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }

    public function getPin(): int
    {
        return $this->pin;
    }

    public function setPin(int $pin): void
    {
        $this->pin = $pin;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): void
    {
        $this->contact = $contact;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): void
    {
        $this->profile = $profile;
    }

    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    public function setCreatedby(?User $createdby): void
    {
        $this->createdby = $createdby;
    }




    private function isObligatory(): bool
    {
        if (QString::_isNull($this->pin))
            throw new Exception('pin_is_required');

        return true;
    }


    /**
     * @throws Exception
     */
    public function save(): ?User
    {
        if (!$this->ToHave())
            return null;
        return self::_toBean($this);

    }

    private function ToHave(): bool
    {
        if (QString::_isNull($this->pin))
            throw new Exception("pin is not valid");
        return true;
    }

    public function delete(): bool
    {
        if ($this->isObligatory()) {
            parent::_toTrash(self::TABLE, $this->id);
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::TOKEN =>  $this->token,
            self::EMAIL =>  ($this->email),
            self::MOBILE =>  (int)($this->mobile),
            //self::PIN =>  $this->pin,
            self::CONTACT => ($this->contact instanceof Contact) ? $this->contact->toArray() : null,
            self::PROFILE => ($this->profile instanceof Profile) ? $this->profile->toArray() : null,
            //self::ISBLOCKED =>  ($this->getIsblocked()),
            //self::ISDELETED =>  ($this->getIsDeleted()),
            //self::CREATEDBY => ($this->createdby instanceof User) ? $this->createdby->toArray() : null,

        ];
    }

    /**
     * @param int $criteria
     * @param $value
     * @return User|null
     */
    static public function _get(int $criteria, $value): ?User
    {
        return match (true) {
            $criteria == Criteria::ID && (int)$value > 0 => self::_toObject(parent::_getOne(self::TABLE, [parent::ID => (int)$value])),
            $criteria == Criteria::TOKEN && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::TOKEN => trim($value)])),
            $criteria == Criteria::MOBILE && !QString::_isNull($value) => self::_toObject(parent::_getOne(self::TABLE, [parent::MOBILE => trim($value)])),
                default => null
        };
    }

    /**
     * @param int $token
     * @return User|null
     */
    static public function _getByToken(int $token): ?User
    {
        $user = R::findOne('users', 'token = ?', [$token]);

        if ($user instanceof RedBeanPHP\OODBBean) {
            $item = self::_toObject($user);

            if ($item instanceof self) {
                return $item;
            }
        }

        return null;
    }
    static public function _checkAccount(int $idContact): ?User
    {
        $user = R::findOne('user', 'contact = ?', [$idContact]);

        if ($user instanceof RedBeanPHP\OODBBean) {
            $item = self::_toObject($user);

            if ($item instanceof self) {
                return $item;
            }
        }

        return null;
    }
    // to bean
    static public function getUserToken($contactView): array    
    {
        $contactlist = [];  
    
        foreach ($contactView as $contact) {
            $user = User::_get(Criteria::TOKEN, (int)$contact);
            if ($user) {
                $contactlist[] = $user->toArray();
            }
        }
    
        return $contactlist;
    }


    static public function splitArrayToString($array) {
        return implode(',', $array);
    }
    static public function setUserToken(array $contactView): string    
    {
        return $contactlist = User::splitArrayToString($contactView);
    }
    static public function unsplitArrayToString($string) {
        return explode(',', $string);
    }
    static public function parseContactsToken($contactTokenString): array
    {
        $contactIds = explode(',', $contactTokenString);
        $contacts = [];
    
        foreach ($contactIds as $contactId) {
            $user = User::_get(Criteria::TOKEN, $contactId);
            if ($user) {
                $contacts[] = $user->toArray();
            }
        }
    
        return $contacts;
    }


    /**
     * @return array|null
     */
    static public function _list(): ?array
    {
        if (!empty($beans = parent::_getAll(self::TABLE, []))) {
            foreach ($beans as $bean)
                if (($item = self::_toObject($bean)) instanceof self)
                    if(!$item->getProfile()->getRoot()){
                        $user[] = $item->toArray();
                    }

        }
        return $user ?? null;
    }

    static public function isEmailFormatValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }



    static public function _getByID(int $id): ?self
    {
        $user = R::findOne('users', 'contact = ?', [$id]);

        if ($user instanceof RedBeanPHP\OODBBean) {
            $item = self::_toObject($user);

            if ($item instanceof self) {
                return $item;
            }
        }

        return null;
    }

    static public function checkUser(string $id): ?bool
    {

        $bean = R::findOne(self::TABLE, 'contact = ?', [trim($id)]);

        if ($bean instanceof RedBeanPHP\OODBBean) {
            $user = self::_toObject($bean);
            if ($user instanceof self) {
                Reply::_error("this_user_already_exists");
            }
        }
        return false;
    }

    
}
