<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    public const PAYMENT_CONFIRMATION = 'Payment Confirmation';
    public const WAITING_CONFIRMATION = 'Waiting Confirmation';
    public const PENDING = 'Pending';
    public const SUCCESSPAID = 'Paid';
    public const DECLINED = 'Declined';

    protected $guarded = ['id'];

    public function scopePaymentConfirmation($query) {
        $query->where('status', self::PENDING)->where('type', self::PAYMENT_CONFIRMATION);
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_id');
    }
}
