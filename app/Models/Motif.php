<?php

namespace App\Models;

use Helper\Constant;

class Motif
{
    private ?int $id;
    private ?int $token;
    private string $name;
    private string $type;
    private Account $account;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param string $name
     * @param string $type
     * @param Account $account
     */
    public function __construct(?int $id, ?int $token, string $name, string $type, Account $account)
    {
        $this->id = $id;
        $this->token = $token;
        $this->name = $name;
        $this->type = $type;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }
    public function toArray(): array
    {
        return [
            Constant::MOTIF => $this->getName(),
        ];
    }

}