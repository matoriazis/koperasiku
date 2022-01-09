<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;

class InstallmentPayment extends Model
{
    use HasFactory;

    public const PAID = 'Lunas';

    protected $guarded = ['id'];

    public function loan() {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
