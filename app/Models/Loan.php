<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\InstallmentPayment;

class Loan extends Model
{
    use HasFactory;

    public const WAITING = 'Menunggu Konfirmasi';
    public const CONFIRMED = 'Pengajuan Diterima';
    public const DECLINEED = 'Pengajuan Ditolak';


    protected $guarded = ['id'];

    public $appends = ['sisa_angsuran', 'angsuran_terakhir'];

    public function getSisaAngsuranAttribute() {
        $totalAngsuran = \App\Models\InstallmentPayment::where('loan_id', $this->id)->count();
        return $this->total_month - $totalAngsuran;
    }
    
    public function getAngsuranTerakhirAttribute() {
        $totalAngsuran = \App\Models\InstallmentPayment::where('loan_id', $this->id)->orderBy('created_at', 'DESC')->first();
        if($totalAngsuran) {
            return date('Y-m-d H:i:s', strtotime($totalAngsuran->created_at));
        }

        return 'Belum ada pembayaran ditemukan';
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_id');
    }
    
    public function installments(){
        return $this->hasMany(InstallmentPayment::class, 'loan_id');
    }
}
