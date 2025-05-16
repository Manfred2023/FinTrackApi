<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Models\Motif;

class JournalRepository
{
    private ?int $id;
    private ?int $token;
    private ?Loan $loan;
    private ?Motif $motif;
}