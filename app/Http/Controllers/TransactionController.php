<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Saving;
use App\Models\Profile;
use \Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $transactions = Transaction::PaymentConfirmation()->with(['user'])->get();
        return response()->json($transactions);
    }

    public function store(Request $request) {
        $params = [
            'code' => \Hash::make($request->_token),
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => Transaction::PAYMENT_CONFIRMATION,
            'created_id' => $this->getUserId(),
            'need_confirmation' => true,
            'path_to_file' => null,
            'type' => Transaction::PAYMENT_CONFIRMATION,
            'status' => Transaction::PENDING,
        ];

        if($request->file('file')){
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $path = $file->store('public/files');

            $f_path = str_replace('public', 'storage', $path);

            $params['path_to_file'] = $f_path;
        }

        $trx = Transaction::create($params);
        if($trx) {
            $profile=Profile::where('user_id', $this->getUserId())->update(['status' => Transaction::WAITING_CONFIRMATION]);
        }

        return redirect(route('member.dashboard'));

    }

    public function confirmTransaction($id, Request $request) {
        $transactions = Transaction::find($id);

        if($transactions) {
            if($request->action === 'decline') {
                $params = [
                    'declined_by' => $this->getUserId(),
                    'declined_at' => Carbon::now()->format('Y-m-d'),
                    'status' => Transaction::DECLINED
                ];
            }else if($request->action === 'confirm') {
                $params = [
                    'confirmed_by' => $this->getUserId(),
                    'confirmed_at' => Carbon::now()->format('Y-m-d'),
                    'status' => Transaction::SUCCESSPAID
                ];
    
                $savingParams = [
                    'code' => \Hash::make(rand(1, 100)),
                    'amount' => $transactions->amount,
                    'user_id' => $transactions->created_id,
                    'description' => 'Deposit awal pendaftaran anggota',
                    'year_month' => Carbon::now()->format('Y-m'),
                    'type' => Saving::POKOK,
                    'status' => Saving::LUNAS,
                    'created_id' => $this->getUserId()
                ];

                $profileParams = [
                    'is_activated' => true,
                    'status' => 'Aktif',
                    'code' => Profile::generateMemberCode()
                ];

                Profile::where('user_id', $transactions->created_id)->update($profileParams);
                Saving::create($savingParams);
            }
    
            $trx = $transactions->update($params);
    
            if($trx) {
                if($request->action === 'confirm') {
                    return redirect(route('officer.dashboard'))->with('success', 'Berhasil melakukan konfirmasi pengajuan pembayaran!');
                }else {
                    return redirect(route('officer.dashboard'))->with('success', 'Berhasil menolak pengajuan pembayaran');
                }
            }else{
                return redirect(route('officer.dashboard'))->with('failed', 'Failed, something went wrong!');
            }
        }
        
        return redirect(route('officer.dashboard'))->with('failed', 'Gagal, transaksi tidak ditemukan!');
    }
}
