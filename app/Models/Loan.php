<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\InstallmentPayment;
use App\Models\Saving;

class Loan extends Model
{
    use HasFactory;

    public const WAITING = 'Menunggu Konfirmasi';
    public const CONFIRMED = 'Pengajuan Diterima';
    public const DECLINEED = 'Pengajuan Ditolak';


    protected $guarded = ['id'];

    public $appends = ['sisa_angsuran', 'angsuran_terakhir', 'total_savings'];

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

    public function getTotalSavingsAttribute() {
        $wajib = $this->savings->where('type', Saving::WAJIB)->sum('amount');
        $sukarela = $this->savings->where('type', Saving::SUKARELA)->sum('amount');

        return $wajib + $sukarela;
    }

    public function savings(){
        return $this->hasMany(Saving::class, 'user_id', 'created_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'created_id');
    }
    
    public function installments(){
        return $this->hasMany(InstallmentPayment::class, 'loan_id');
    }
}
