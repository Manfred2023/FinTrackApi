<?php

namespace App\Models;

use DateTime;
use Helper\Constant;

class Journal
{
    private ?int $id;
    private ?int $token;
    private Loan $loan;
    private Motif $motif;
    private float $amount;
    private DateTime $date;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param Loan $loan
     * @param Motif $motif
     * @param float $amount
     * @param DateTime $date
     */
    public function __construct(?int $id, ?int $token, Loan $loan, Motif $motif, float $amount, DateTime $date)
    {
        $this->id = $id;
        $this->token = $token;
        $this->loan = $loan;
        $this->motif = $motif;
        $this->amount = $amount;
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

    public function getLoan(): Loan
    {
        return $this->loan;
    }

    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }

    public function getMotif(): Motif
    {
        return $this->motif;
    }

    public function setMotif(Motif $motif): void
    {
        $this->motif = $motif;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
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
            Constant::TOKEN => $this->token,
            Constant::AMOUNT => $this->amount,
            Constant::LOAN => $this->loan->toArray(),
            Constant::MOTIF => $this->motif->toArray(),
            Constant::DATE  => $this->date,
        ];
    }
}