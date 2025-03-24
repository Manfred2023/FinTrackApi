<?php

namespace App\Models;

use Helper\Constant;

class Account
{
    private ?int $id;
    private ?int $token;
    private float $amount;
    private User $user;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param float $amount
     * @param User $user
     */
    public function __construct(?int $id, ?int $token, float $amount, User $user)
    {
        $this->id = $id;
        $this->token = $token;
        $this->amount = $amount;
        $this->user = $user;
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    public function toArray(): array
    {
        return [
            Constant::AMOUNT => $this->getAmount(),
            Constant::USER => $this->getUser()->getNickname(),
        ];
    }


}