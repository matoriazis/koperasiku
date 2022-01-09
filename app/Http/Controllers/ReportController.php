<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function slipMember(Request $request) {
        return view('pages.member.reports.slip', $this->data);
    }
}
