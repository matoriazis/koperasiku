<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Saving;
use App\Models\Loan;
use App\Models\Profile;
use App\Models\InstallmentPayment;

use PDF;
use \Carbon\Carbon;

class ReportController extends Controller
{
    public function slipMember(Request $request) {
        return view('pages.member.reports.slip', $this->data);
    }

    public function slipMemberAction(Request $request) {
        if(!empty($request->id_user)) {

            $dateParam = $request->start;
            $userId = \Auth::user()->id;

            $biodata = Profile::where('user_id', $request->id_user)->first();

            if(!$biodata->is_activated) {
                return redirect(route('member.slip.index'))->with('failed', 'Akun anda belum aktif!');
            }
            
            if(Carbon::parse($dateParam)->firstOfMonth()->lt(Carbon::parse($biodata->created_at)->firstOfMonth())) {
                return redirect(route('member.slip.index'))->with('failed', 'Permintaan ditolak, bulan yang anda minta melewati bulan pendaftaran anda pada ' . Carbon::parse($biodata->created_at)->format('M Y'));
            }

            if(!Carbon::parse($dateParam)->gt(Carbon::now())) {
                $month = Carbon::parse($dateParam)->endOfMonth()->format('Y-m-d');

                $savingPokok = Saving::where('created_at', '<=', $month)->where('user_id', $userId)->where('type', Saving::POKOK)->sum('amount');
                $savingWajib = Saving::where('created_at', '<=', $month)->where('user_id', $userId)->where('type', Saving::WAJIB)->sum('amount');
                $savingSukarela = Saving::where('created_at', '<=', $month)->where('user_id', $userId)->where('type', Saving::SUKARELA)->sum('amount');

                $reducePokok = Saving::where('created_at', 'like', $dateParam . '%')->where('user_id', $userId)->where('type', Saving::POKOK)->sum('amount');
                $reduceWajib = Saving::where('created_at', 'like', $dateParam . '%')->where('user_id', $userId)->where('type', Saving::WAJIB)->sum('amount');
                $reduceSukarela = Saving::where('created_at', 'like', $dateParam . '%')->where('user_id', $userId)->where('type', Saving::SUKARELA)->sum('amount');
                $reduceLoan = Loan::where('created_at', 'like', $dateParam . '%')->where('is_confirmed', true)->where('created_id', $userId)->sum('loan_service');
                // return Carbon::parse($dateParam)->firstOfMonth()->format('Y-m-d');
                $remaining = Loan::where('created_id', $userId)->where('created_at', '<=', Carbon::parse($dateParam)->endOfMonth()->format('Y-m-d'))->first();
                $installment = 0;

                if($remaining) {
                    $installment = InstallmentPayment::where('created_at', 'like', $dateParam . '%')->where('loan_id', $remaining->id)->sum('amount');
                }
                
                $slip = [
                    'header' => [
                        'code' => $biodata->code,
                        'name' => $biodata->fullname,
                        'periode' => Carbon::parse($dateParam)->format("M'y"),
                        'dept' => $biodata->job_dept
                    ],
                    'incomes' => [
                        'saving_pokok' => $savingPokok,
                        'saving_wajib' => $savingWajib,
                        'saving_sukarela' => $savingSukarela,
                        'installment_remaining' => $remaining ? $remaining->sisa_angsuran : 0
                    ],
                    'reductions' => [
                        'saving_pokok' => $reducePokok,
                        'saving_wajib' => $reduceWajib,
                        'saving_sukarela' => $reduceSukarela,
                        'loan' => $reduceLoan,
                        'installment' => $installment,
                        'loan_service' => $remaining ? $remaining->loan_service : 0,
                        'total' => $reducePokok + $reduceWajib + $reduceSukarela + $reduceLoan
                    ]
                ];

                $this->data['slip'] = $slip;

                return view('pages.member.reports.slip', $this->data);
            }

            return redirect(route('member.slip.index'))->with('failed', 'Permintaan ditolak, anda tidak bisa melihat slip untuk bulan yang akan datang!');
        }
    
        return redirect(route('member.slip.index'))->with('failed', 'Permintaan ditolak, karena parameter tidak valid!');
    }
    
    public function incomeOutcomeView(Request $request) {
        return view('pages.officer.reports.incomeindex', $this->data);
    }

    public function incomeOutcome(Request $request) {
        $start = $request->start;
        $end = $request->end;

        $first_month = Carbon::parse($start)->addMonth(-1)->endOfMonth()->format('Y-m') . '-01';
        $last_month = Carbon::parse($end)->addMonth(1)->format('Y-m');

        $totalSaving = Saving::whereBetween('created_at', [$first_month, $last_month . '-01'])->sum('amount');
        $totalIntallment = InstallmentPayment::whereBetween('created_at', [$first_month, $last_month . '-01'])->where('status', InstallmentPayment::PAID)->sum('amount');

        $totalLoan = Loan::whereBetween('created_at', [$first_month, $last_month . '-01'])->where('status', Loan::CONFIRMED)->sum('amount');

        $finalIncome = $totalSaving + $totalIntallment;
        $finalOutcome = $totalLoan;

        $savingPokok = Saving::whereBetween('created_at', [$first_month, $last_month . '-01'])->where('type', Saving::POKOK)->sum('amount');
        $savingWajib = Saving::whereBetween('created_at', [$first_month, $last_month . '-01'])->where('type', Saving::WAJIB)->sum('amount');
        $savingSukarela = Saving::whereBetween('created_at', [$first_month, $last_month . '-01'])->where('type', Saving::SUKARELA)->sum('amount');

        $this->data = [
            'start' => date('M Y', strtotime($start . '-01')),
            'end' => date('M Y', strtotime($end . '-01')),
            'incomes' => $finalIncome,
            'outcomes' => $finalOutcome,
            'income_detail' => [
                'saving_pokok' => $savingPokok,
                'saving_wajib' => $savingWajib,
                'saving_sukarela' => $savingSukarela,
                'angsuran' => $totalIntallment,
            ],
            'outcome_detail' => [
                'loans' => $totalLoan
            ]
        ];
        // dd($this->data);

        $pdf = PDF::loadview('reports.incomeoutcome', $this->data);
    	return $pdf->stream('report-bulanan');

    }
}
