<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Saving;
use App\Models\Loan;
use \Carbon\Carbon;

class DashboardController extends Controller
{
    public function chief() {
        $thisMonth = Carbon::now()->format('Y-m') . '%';

        $user = User::where('role', 'member')->count();
        $simpananPokok = Saving::where('type', Saving::POKOK)->sum('amount');
        $simpananWajib = Saving::where('type', Saving::WAJIB)->sum('amount');
        $simpananSukarela = Saving::where('type', Saving::SUKARELA)->sum('amount');
        $simpananAll = Saving::sum('amount');
        $loanActive = Loan::where('is_confirmed', true)->where('is_settled', false)->count();
        
        $userBulanan = User::where('role', 'member')->where('created_at', 'like', $thisMonth)->count();
        $simpananPokokBulanan = Saving::where('created_at', 'like', $thisMonth)->where('type', Saving::POKOK)->sum('amount');
        $simpananWajibBulanan = Saving::where('created_at', 'like', $thisMonth)->where('type', Saving::WAJIB)->sum('amount');
        $simpananSukarelaBulanan = Saving::where('created_at', 'like', $thisMonth)->where('type', Saving::SUKARELA)->sum('amount');
        $simpananAllBulanan = Saving::where('created_at', 'like', $thisMonth)->sum('amount');
        $loanActiveBulanan = Loan::where('is_confirmed', true)->where('is_settled', false)->where('confirmed_at', 'like', $thisMonth)->count();

        $this->data['count'] = [
            'member' => $user,
            'simpanan_pokok' => $simpananPokok,
            'simpanan_wajib' => $simpananWajib,
            'simpanan_sukarela' => $simpananSukarela,
            'simpanan_all' => $simpananAll,
            'loan_active' => $loanActive
        ];
        $this->data['monthly'] = [
            'member' => $userBulanan,
            'simpanan_pokok' => $simpananPokokBulanan,
            'simpanan_wajib' => $simpananWajibBulanan,
            'simpanan_sukarela' => $simpananSukarelaBulanan,
            'simpanan_all' => $simpananAllBulanan,
            'loan_active' => $loanActiveBulanan
        ];
        return view('pages/chief/dashboard/index', $this->data);
    }
    
    public function officer() {
        $user = User::where('role', 'member')->count();
        $simpananPokok = Saving::where('type', Saving::POKOK)->sum('amount');
        $simpananWajib = Saving::where('type', Saving::WAJIB)->sum('amount');
        $simpananSukarela = Saving::where('type', Saving::SUKARELA)->sum('amount');
        $simpananAll = Saving::sum('amount');
        $loanActive = Loan::where('is_confirmed', true)->where('is_settled', false)->count();
        $transactions = Transaction::PaymentConfirmation()->limit(10)->orderBy('created_at', 'desc')->get();
        $this->data['count'] = [
            'member' => $user,
            'simpanan_pokok' => $simpananPokok,
            'simpanan_wajib' => $simpananWajib,
            'simpanan_sukarela' => $simpananSukarela,
            'simpanan_all' => $simpananAll,
            'loan_active' => $loanActive
        ];
        $this->data['transactions'] = $transactions;
        return view('pages/officer/dashboard/index', $this->data);
    }

    public function member() {
        $profile = Profile::where('user_id', \Auth::user()->id)->first();
        
        $this->data['member_code'] = $profile && $profile->code ? $profile->code : false;
        $this->data['profile_submitted'] = $profile ? true : false;
        $this->data['is_active'] = $profile && $profile->is_activated ? true : false;
        $this->data['status_pending'] = $profile && $profile->status == Transaction::WAITING_CONFIRMATION ? true : false;
      
        return view('pages/member/dashboard/index', $this->data);
    }

    public function paymentMenu(Request $request) {
        return view('pages.officer.payments.menu');
    }
}
