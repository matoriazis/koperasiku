<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Saving;
use App\Models\Loan;
use App\Models\InstallmentPayment;

use PDF;
use \Carbon\Carbon;

class ReportController extends Controller
{
    public function slipMember(Request $request) {
        return view('pages.member.reports.slip', $this->data);
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
