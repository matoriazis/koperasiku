<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Profile;
use App\Models\Saving;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function indexMember(Request $request) {
        $loans = Loan::with('user')->where('created_id', $this->getUserId())->orderBy('created_at', 'desc')->get();

        $this->data['loans'] = $loans;

        return view('pages.member.loan.index', $this->data);
    }

    public function indexOfficer(Request $request) {
        $loans = Loan::with(['user.profile'])->orderBy('created_at', 'desc');
        $filterStatus = 'all';
        $date = '';
        $filters = [
            [
                'value' => 'all',
                'display' => 'Semua'
            ],
            [
                'value' => 'accept',
                'display' => 'Diterima'
            ],
            [
                'value' => 'pending',
                'display' => 'Pending'
            ],
            [
                'value' => 'decline',
                'display' => 'Ditolak'
            ]
        ];

        if(isset($request->month)) {
            $date = $request->month;
            $loans->where('created_at', 'like', $date .'%');
        }

        if(isset($request->status)) {
            $status = $request->status;
            if($status != 'all') {
                $filterStatus = '';

                if($status == 'accept') {
                    $filterStatus = Loan::CONFIRMED;
                }else if($status == 'pending') {
                    $filterStatus = Loan::WAITING;
                }else if($status == 'decline') {
                    $filterStatus = Loan::DECLINEED;
                }

                $loans->where('status', 'like', $filterStatus);
            }
        }

        $this->data['filter_status'] = $request->status;
        $this->data['filter_date'] = $date;
        $this->data['status_list'] = $filters;
        $this->data['loans'] = $loans->get();
        return view('pages.officer.loan.index', $this->data);
    }

    public function showMember($id, Request $request) {
        $this->data['loan'] = Loan::with('installments')->find($id);
        return view('pages.member.loan.show', $this->data);
    }

    public function create(Request $request) {
        $profile = Profile::where('user_id', $this->getUserId())->first();
        if($profile){
            $loan = Loan::where('created_id', $this->getUserId())->where('status', Loan::WAITING)->first();
            if(!$loan) {
                $this->data['profile'] = $profile;
                $this->data['current_saving'] = (int) Saving::where('user_id', $this->getUserId())
                                ->where('type', Saving::WAJIB)
                                ->orWhere('user_id', $this->getUserId())
                                ->where('type', Saving::SUKARELA)
                                ->sum('amount');
                $this->data['current_saving_formatted'] = 'Rp. ' . number_format($this->data['current_saving']);
                $this->data['max_loan_formatted'] = $this->data['current_saving'] * 2;
                $this->data['max_loan_formatted'] = 'Rp. ' . number_format($this->data['current_saving'] * 2);
                return view('pages.member.loan.form', $this->data);
            }
            return redirect(route('member.loans.all'))->with('failed', 'Anda tidak dapat mengajukan kembali, tunggu pengajuan sebelumnya dikonfirmasi!');
        }

        dd('Kamu belum mengisi formulir pendaftaran!');
    }

    public function store(Request $request) {
        if(!$request->sign) {
            return redirect()->back()->with('failed', 'Tanda tangan tidak valid, silahkan coba lagi');
        }
        $sign = $this->saveSignature($request->sign);
        $params = $request->only(['amount', 'loan_service', 'total', 'description', 'installment_per_month', 'total_month']);
        $params['type'] = 'Angsuran';
        $params['created_id'] = $this->getUserId();
        $params['status'] = Loan::WAITING;
        $params['signature'] = $sign;
        
        $loan = Loan::create($params);

        if($loan) {
            return redirect(route('member.loans.all'))->with('success', 'Sukes mengajukan peminjaman, silahkan tunggu proses verifikasi oleh petugas');
        }

        return redirect(route('member.loans.all'))->with('failed', 'Gagal melakukan pengajuan peminjaman, silahkan coba beberapa saat lagi');
    }


    public function saveSignature($base64_image) {
        //get the base-64 from data
        $base64_str = substr($base64_image, strpos($base64_image, ",")+1);
        //decode base64 string
        $imgname = time() . rand() . 'signature.png';
        $image = base64_decode($base64_str);
        \Storage::disk('public')->put('signature/'.$imgname, $image);
        $storagePath = \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $response = array(
            'status' => 'success',
        );

        return 'storage/signature/'.$imgname;
}

    public function confirmIndex(Request $request) {
        $this->data['loans'] = Loan::with(['user.profile'])->where('status', Loan::WAITING)->orderBy('created_at', 'desc')->get();
        // return $this->data;
        return view('pages/chief/loan/confirm-index', $this->data);
    }
    
    public function actionConfirm(Request $request){
        $message = '';
        if($request->action === 'confirmed') {
            $params = [
                'is_confirmed' => true,
                'confirmed_by' => $this->getUserId(),
                'confirmed_at' => Carbon::now()->format('Y-m-d H:i:d'),
                'status' => Loan::CONFIRMED
            ];
            $message = 'Berhasil melakukan konfirmasi peminjaman dengan status diterima';
        }elseif($request->action === 'rejected') {
            $params = [
                'is_confirmed' => false,
                'declined_by' => $this->getUserId(),
                'declined_at' => Carbon::now()->format('Y-m-d H:i:d'),
                'declined_reason' => $request->cancelation_note,
                'status' => Loan::DECLINEED
            ];
            $message = 'Pengajuan peminjaman berhasil ditolak';
        }
        $loan = Loan::find($request->id)->update($params);
        if($loan) {
            return redirect(route('chief.confirm.loan.index'))->with('success', $message);
        }
        return redirect(route('chief.confirm.loan.index'))->with('failed', 'something went wrong!');
    }
}