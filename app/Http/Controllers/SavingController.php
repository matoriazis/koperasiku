<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saving;

class SavingController extends Controller
{
    public function indexMember(Request $request) {
        
        $this->data['savings_pokok'] = Saving::with('user')->where('user_id', \Auth::user()->id)->where('type', Saving::POKOK)->get();
        $this->data['savings_wajib'] = Saving::with('user')->where('user_id', \Auth::user()->id)->where('type', Saving::WAJIB)->get();
        $this->data['savings_sukarela'] = Saving::with('user')->where('user_id', \Auth::user()->id)->where('type', Saving::SUKARELA)->get();

        return view('pages.member.saving.index', $this->data);
    }

    public function index($type, Request $request) {
        $simpanan = Saving::with(['user.profile'])->where('type', $type)->orderBy('created_at', 'DESC')->get();
        $this->data['savings'] = $simpanan;
        $view = '';
        if($type === 'wajib') {
            $view = 'pages.officer.saving.wajib';
        }elseif($type === 'sukarela') {
            $view = 'pages.officer.saving.sukarela';
        }else {
            $view = 'pages.officer.saving.pokok';
        }

        return view($view, $this->data);
    }

    public function store(Request $request) {
        $params = $request->except('_token');
        $params['code'] = \Hash::make($request->_token);
        $params['created_id']=$this->getUserId();
        $params['description']= 'Setoran '.$params['type'];
        $params['status'] = 'Lunas';

        $save = Saving::create($params);
        if($save) {
            return redirect(route('officer.payments.simpanan'))->with('success', 'Berhasil menyimpan setoran!');
        }
        return redirect(route('officer.payments.simpanan'))->with('failed', 'Kesalah terjadi, silahkan coba lagi!');
    }
}
