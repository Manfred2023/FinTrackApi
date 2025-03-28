<?php

namespace App\Models;

use Helper\Constant;
use Helper\Helper;
use Helper\Reply;

class Contact
{
    private ?int $id;
    private ?int $token;
    private string $name;
    private string $mobile;
    private ?string $location;
    private Account $account;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param string $name
     * @param string $mobile
     * @param string|null $location
     * @param Account $account
     */
    public function __construct(?int $id, ?int $token, string $name, string $mobile, ?string $location, Account $account)
    {
        $this->id = $id;
        $this->token = $token;
        $this->name = $name;
        $this->mobile = $mobile;
        $this->location = $location;
        $this->account = $account;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

      public function validateContact(): void
    {
        $errors = [];

        if (strlen($this->name) > 50) {
            $errors[] = Constant::INVALID_NAME;
        }
        if (!Helper::isCameroonianPhoneNumber($this->mobile)) {
            $errors[] = Constant::INVALID_MOBILE;
        }

        if (!empty($errors)) {
            Reply::_error($errors,code: 400);
        }
    }
    public function toArray(): array
    {
        return [
            Constant::TOKEN => $this->token ?? null,
            Constant::NAME => $this->name,
            Constant::MOBILE => (int)$this->mobile ?? null,
            Constant::LOCATION => $this->location,
        ];
    }


}