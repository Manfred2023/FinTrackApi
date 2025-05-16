<?php

namespace App\Models;

use DateTime;
use Helper\Constant;

class Loan
{
    private ?int $id;
    private ?int $token;
    private float $amount;
    private bool $isdone;
    private bool $isloan;
    private Contact $contact;
    private DateTime $date;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param float $amount
     * @param bool $isdone
     * @param bool $isloan
     * @param Contact $contact
     * @param DateTime $date
     */
    public function __construct(?int $id, ?int $token, float $amount, bool $isdone, bool $isloan, Contact $contact, DateTime $date)
    {
        $this->id = $id;
        $this->token = $token;
        $this->amount = $amount;
        $this->isdone = $isdone;
        $this->isloan = $isloan;
        $this->contact = $contact;
        $this->date = $date;
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

    public function isIsdone(): bool
    {
        return $this->isdone;
    }

    public function setIsdone(bool $isdone): void
    {
        $this->isdone = $isdone;
    }

    public function isIsloan(): bool
    {
        return $this->isloan;
    }

    public function setIsloan(bool $isloan): void
    {
        $this->isloan = $isloan;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): void
    {
        $this->contact = $contact;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function toArray(): array
    {
        return [
            Constant::TOKEN => $this->token ?? null,
            Constant::AMOUNT => $this->amount,
            Constant::ISDONE => $this->isdone,
            Constant::ISLOAN => $this->isloan,
            Constant::CONTACT => $this->contact,
        ];
    }

}