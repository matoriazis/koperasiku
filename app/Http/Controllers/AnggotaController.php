<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class AnggotaController extends Controller
{
    public function index(Request $request) {
        $memberList = Profile::where('is_activated', true)->orderBy('fullname', 'ASC')->get();
        $this->data = [
            'members' => $memberList
        ];

        return view('pages.officer.members.index', $this->data);
    }
}
