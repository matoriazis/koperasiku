@extends('../../../../templates/layouts')

@section('contents')
    <h1>Selamat Datang {{ \Auth::user()->name }}</h1>
    @if (!$profile_submitted)
        <div class="alert alert-info alert-with-icon" data-notify="container">
            <span data-notify="icon" class="tim-icons icon-bell-55"></span>
            <span data-notify="message">Anda belum melengkapi formulir pendaftaran silahkan lengkapi formulir pendaftaran,
                <a href="{{ route('member.form.register') }}" style="color: black">Klik disini untuk melengkapi</a></span>
        </div>
    @endif

    @if ($profile_submitted && !$is_active && $status_pending == '')
        <div class="alert alert-info alert-with-icon" data-notify="container">
            <span data-notify="icon" class="tim-icons icon-bell-55"></span>
            <span data-notify="message">
                Untuk mengatifkan akun anggota koperasi, anda harus mentransfer deposit pertama sebesar <b>Rp. 30.000; </b>
                dana tersebut akan ditambahkan ke dalam saldo <b>Simpanan Pokok</b> anda! <br> <br>
                <b>Silahkan transfer ke: </b>
                <ul style="color: white">
                    <li class="text-white">Nama Bank : <b>BCA</b></li>
                    <li class="text-white">No Rekening : <b>33123456789</b></li>
                    <li class="text-white">Atas Nama : <b>Aliando Syarif</b></li>
                </ul>
                <i>*Jika sudah melakukan transfer, silahkan lakukan konfirmasi pembayaran dengan cara klik tombol dibawah
                    ini.</i> <br>
                <div>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Konfirmasi
                        Pembayaran</button>
                </div>
            </span>
        </div>
    @endif

    @if ($profile_submitted && !$is_active && $status_pending === true)
        <div class="alert alert-info alert-with-icon" data-notify="container">
            <span data-notify="icon" class="tim-icons icon-bell-55"></span>
            <span data-notify="message">Pembayaran sedang diproses, silahkan tunggu sampai petugas melakukan verifikasi!</span>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('member.confirm.payment')}}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="form-group">
                            <label for="">Jumlah <span class="mandatory">*</span></label>
                            <input type="number" value="30000" required class="form-control" name="amount" placeholder="Masukan jumlah">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Transfer <span class="mandatory">*</span></label>
                            <input type="date" required class="form-control" name="date" value="{{date('Y-m-d')}}" placeholder="Masukan Tanggal">
                        </div>
                        <div>
                            <label for="file">Unggah Bukti Pembayaran</label> <br>
                            <input type="file" name="file" accept="image/*" >
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi Pembayaran Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .mandatory {
            color: red
        }
    </style>
@endpush