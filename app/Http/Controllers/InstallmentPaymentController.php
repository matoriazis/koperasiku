<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Profile;
use App\Models\InstallmentPayment;

class InstallmentPaymentController extends Controller
{
    public function indexOfficer(Request $request) {
        $installments = InstallmentPayment::with('loan.user.profile')->orderBy('created_at', 'desc')->get();
        $this->data['installments'] = $installments;

        return view('pages.officer.installment.index', $this->data);
    }

    public function getAngsuran($id, Request $request) {
        $profile = Profile::find($id);
        if($profile) {
            $this->data['loans'] = Loan::with(['user.profile'])->where(['created_id' => $profile->user_id, 'is_confirmed' => true, 'status' => Loan::CONFIRMED, 'is_settled' => false])->first();
        }
        
        $response = [
            'data' => $this->data
        ];
        return response()->json($response);
    }

    public function store(Request $request) {
        $profile = Profile::find($request->profile_id);
        if($profile) {
            $loan = Loan::find($request->loan_id);
            if($loan) {
                $angsuran = InstallmentPayment::where('loan_id', $loan->id)->where('created_at', 'like', $request->month . '%')->first();
                if($angsuran) {
                    return redirect(route('officer.payments.angsuran'))
                            ->with('failed', 'Pembayaran bulan '.date('F',strtotime($request->month . '-01' )). ' telah dibayar pada ' . date('d F Y H:i:s',strtotime($angsuran->created_at)));
                }else{
                    $params = [
                        'loan_id' => (int) $request->loan_id,
                        'amount' => (int) $loan->installment_per_month,
                        'month' => $request->month,
                        'status' => InstallmentPayment::PAID,
                        'created_id' => $this->getUserId(),
                        'description' => 'Pembayaran angsuran peminjaman bulan ' . date('F Y',strtotime($request->month . '-01'))
                    ];
                    InstallmentPayment::create($params);
                    return redirect(route('officer.payments.angsuran'))->with('success', 'Pembayaran angsuran sukses!');
                }
            }
        }
        return redirect(route('officer.payments.angsuran'))->with('failed', 'Pembayaran ditolak, karena terindikasi kecurangan!');
    }
}
