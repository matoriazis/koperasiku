<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class PaymentController extends Controller
{
    public function angsuranIndex(Request $request) {
        $this->data['members'] = Profile::where('is_activated', true)->get();
        return view('pages.officer.payments.angsuranIndex', $this->data);
    }
    
    public function savingIndex(Request $request) {
        $this->data['members'] = Profile::where('is_activated', true)->get();
        return view('pages.officer.payments.simpananIndex', $this->data);
    }
}
