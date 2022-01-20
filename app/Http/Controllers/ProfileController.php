<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.member.profile.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->except(['_token']);
        $payload['status'] = Profile::PROFILE_SUBMITTED;
        $payload['user_id'] = $this->getUserId();
        $payload['salary'] = 0;
        $profile = Profile::create($payload);

        return redirect(route('member.dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $profile = Profile::where('user_id', \Auth::user()->id)->first();
        $this->data['profile'] = $profile;
        return view('pages.member.profile.show', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $params = $request->only(['phone', 'address']);

        $profile = Profile::find($id);

        if($profile) {
           $update = $profile->update($params);
           return redirect(route('member.profile.show'))->with('success', 'Berhasil menyimpan perubahan');
        }
        return redirect(route('member.profile.show'))->with('failed', 'Gagal Menyimpan Perubahan, coba lagi beberapa saat');
    }
}
