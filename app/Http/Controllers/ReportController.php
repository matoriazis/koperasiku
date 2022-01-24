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
                        'total' => $reducePokok + $reduceWajib + $reduceSukarela + $reduceLoan + $installment
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

    public function shuReport(Request $request) {
        return view('pages.chief.reports.index', $this->data);
    }

    public function detailedShu(Request $request) {
        $list_anggota = Profile::where('is_activated', true)->orderBy('fullname', 'ASC')->get();

        $tahun = $request->year;
        $list_bulan = $this->_getListBulan($tahun);

        if(count($list_anggota) > 0) {
            $data = [];
            foreach($list_anggota as $anggota) {
                $temp = [
                    'name' => $anggota->fullname
                ];

                $dataPerUser = [];
                foreach($list_bulan as $bulan) {
                    $loan = Loan::where('created_id', $anggota->user_id)
                                    ->where('is_confirmed', true)->where('confirmed_at', 'like', $bulan['value'] .'%')->sum('loan_service');

                    if($loan) {
                        $savingPokok = Saving::where('user_id', $anggota->user_id)->where('type', Saving::POKOK)->where('created_at', 'like', $bulan['value'] .'%')->sum('amount');
                        $dataPerUser[] = [
                            'month' => $bulan['value'],
                            'total' => $loan + $savingPokok
                        ];
                    }else {
                        $dataPerUser[] = [
                            'month' => $bulan['value'],
                            'total' => 0
                        ];
                    }
                }

                $temp['data'] = $dataPerUser;

                $data[] = $temp;
            }
            $this->data['detail_shu'] = $data;
            $this->data['selected_year'] = $request->year;
            $this->data['list_month'] = $list_bulan;

            return view('pages.chief.reports.index', $this->data);
        }

        return 'Belum Ada Anggota';
    }

    private function _getListBulan($tahun) {
        $temp = [];
        $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        for ($i=1; $i <= 12 ; $i++) { 
            if($i < 10) {
                $temp[] = [
                    'label' => $monthNames[$i-1],
                    'value' => $tahun . '-0'.$i
                ];
            }else{
                $temp[] = [
                    'label' => $monthNames[$i-1],
                    'value' => $tahun . '-'.$i
                ];
            }
        }
        return $temp;
    }

    public function generateReportShu($year, Request $request) {
        if(!empty($year)) {
            $paramYear = $year . '%';

            $totalShu = $this->_getTotalShu($year);
            $danaSosial = $totalShu * 0.1;
            $danaKematian = $totalShu * 0.1;
            $gajiPengurus = $totalShu * 0.1;
            $sisaShu = $totalShu - ($danaSosial + $danaKematian + $gajiPengurus);
            $simpananWajib = (int) Saving::where('created_at', 'like', $paramYear)->where('type', Saving::WAJIB)->sum('amount');
            $simpananSukarela = (int) Saving::where('created_at', 'like', $paramYear)->where('type', Saving::SUKARELA)->sum('amount');;

            $totalSimpanan = $simpananWajib + $simpananSukarela;
            $prosentase = $sisaShu / $totalSimpanan * 100;
            $temp_prosentase = 4.5;
            $detailData = $this->_getDetailDataShu($year, $prosentase);

            $totalAll = [
                'total_simpanan_wajib' => 0,
                'total_simpanan_sukarela' => 0,
                'total' => 0,
                'total_shu_didapat' => 0,
                'grand_total' => 0,
            ];

            $shuData = [
                'total_shu' => $totalShu,
                'dana_sosial' => $danaSosial,
                'dana_kematian' => $danaKematian,
                'gaji_pengurus' => $gajiPengurus,
                'total_operasional' => $danaSosial + $danaKematian + $gajiPengurus,
                'sisa_shu' => $sisaShu,
                'simpanan_wajib' => $simpananWajib,
                'simpanan_sukarela' => $simpananSukarela,
                'total_simpanan' => $totalSimpanan,
                'detail_data' => $detailData,
                'total_all' => $totalAll,
                'prosentase' => $prosentase
            ];

            $this->data = $shuData;

            $pdf = PDF::loadview('pages.chief.reports.report-view', $this->data);
            return $pdf->stream('report-bulanan');
        }

        return redirect(route('chief.report.index'))->with('failed', 'Parameter tidak valid');
    }

    private function _getTotalShu($year) {
        $total = 0;

        $list_anggota = Profile::where('is_activated', true)->orderBy('fullname', 'ASC')->get();

        $tahun = $year;
        $list_bulan = $this->_getListBulan($tahun);

        if(count($list_anggota) > 0) {
            foreach($list_anggota as $anggota) {
                $totalPerUser = 0;
                foreach($list_bulan as $bulan) {
                    $loan = Loan::where('created_id', $anggota->user_id)
                                    ->where('is_confirmed', true)->where('confirmed_at', 'like', $bulan['value'] .'%')->sum('loan_service');

                    if($loan) {
                        $savingPokok = Saving::where('user_id', $anggota->user_id)->where('type', Saving::POKOK)->where('created_at', 'like', $bulan['value'] .'%')->sum('amount');
                        $totalPerUser += ($loan + $savingPokok);
                    }else {
                        $totalPerUser += 0;
                    }
                }

                $total += $totalPerUser;
            }
            // return here
            return $total;
        }

        return 'Belum Ada Anggota';
    }

    private function _getDetailDataShu($year, $prosentase) {
        $tahun = $year;
        $list_bulan = $this->_getListBulan($tahun);
        $list_anggota = Profile::where('is_activated', true)->orderBy('fullname', 'ASC')->get();
        
        $total = 0;

        if(count($list_anggota) > 0) {
            $data = [];
            foreach($list_anggota as $anggota) {
                $temp = [
                    'name' => $anggota->fullname
                ];
                $wajib = 0;
                $sukarela = 0;
                foreach($list_bulan as $bulan) {
                    $amountWajibPerMonth = Saving::where('user_id', $anggota->user_id)
                                            ->where('type', Saving::WAJIB)
                                            ->where('created_at', 'like', $bulan['value'] . '%')->sum('amount');

                    $amountSukarelaPerMonth = Saving::where('user_id', $anggota->user_id)
                                                    ->where('type', Saving::SUKARELA)
                                                    ->where('created_at', 'like', $bulan['value'] . '%')->sum('amount');

                    $wajib += $amountWajibPerMonth;
                    $sukarela += $amountSukarelaPerMonth;
                }

                $total = $wajib + $sukarela;
                $shuDidapat = $total * ($prosentase / 100);

                $temp['wajib'] = $wajib;
                $temp['sukarela'] = $sukarela;
                $temp['total'] = $total;
                $temp['shu_didapat'] = $shuDidapat;
                $temp['grand_total'] = $sukarela + $shuDidapat;

                $data[] = $temp;
            }
            return $data;
        }
    }
}

// public function detailedShuBackup(Request $request) {
//     $year = '2022%';
//     return \DB::select(\DB::raw("WITH anggota_list AS (
//                     select 
//                     p.id, p.user_id, p.fullname
//                     from profiles p join users u on p.user_id = u.id where p.is_activated = true
//                 )
//             , saving_sukarela_list AS (
//                     select s.user_id, s.year_month,
//                     IF
//                         ((select fl.id 
//                             from loans fl
//                             where fl.created_id = s.user_id and fl.confirmed_at like ?) 
//                             is not null, 
//                                 sum(s.amount) + (select loans.loan_service
//                                                                         from loans where loans.created_id = s.user_id and loans.confirmed_at like ?), 
//                                 '0') as total
//                     from savings s where s.type = 'Pokok' 
//                     and s.year_month like ?
//                     group by s.user_id, s.year_month
//                 )
//         SELECT al.*, sl.total, sl.year_month 
//         from anggota_list al 
//         left join saving_sukarela_list sl 
//         on al.user_id = sl.user_id 
//         order by sl.year_month ASC
//         "), [$year, $year, $year]);
// }