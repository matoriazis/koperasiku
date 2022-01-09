@extends('layouts.app')

@section('content')
    <div class="card2 card border-0 px-4 py-5">
        <h2>KOPERASI SIMPAN PINJAM</h2>
        <p>PT WARNA MANDIRI</p>
        <h2 style="margin-bottom: 20px;"></h2>
        <form method="POST" action="{{ route('login') }}"> @csrf
            <div class="row px-3">
                <label>Nama Pengguna</label>
                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row px-3">
                <label for="Kata Sandi">Kata Sandi</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-4 px-3">
                <small class="font-weight-bold">Belum punya akun? <a class="text-danger " href="{{route('register')}}">Daftar
                        disini</a></small>
            </div>
            <button style="width: 100%; border-radius: 25px;" type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>
        </form>
    </div>
@endsection
