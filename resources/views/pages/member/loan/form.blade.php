@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto" style="width: 80%; padding: 10px;">
                <div class="card-header">
                    <div class="row">
                        <h3 class="mx-auto">Formulir Pengajuan Peminjaman</h3>
                        <p style="padding: 10px;">Anda hanya dapat melakukan peminjaman sebesar 2x lipat dari jumlah
                            simpanan anda sebesar <b>{{ $current_saving_formatted }}</b>, atau maksimal peminjaman anda
                            sebesar <b>{{ $max_loan_formatted }}</b></b></p>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.loans.store') }}" method="POST"> @csrf
                        <h4>Pemohon :</h4>
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="name" required class="form-control" readonly
                                value="{{ $profile->fullname }}" placeholder="Masukan Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="code">No Anggota <span class="required">*</span></label>
                            <input type="text" name="code" required class="form-control" readonly
                                value="{{ $profile->code }}" placeholder="No Anggota">
                        </div>
                        <div class="form-group">
                            <label for="bagian">Bagian/Divisi <span class="required">*</span></label>
                            <input type="text" name="bagian" required class="form-control" readonly
                                value="{{ $profile->job_dept }}" placeholder="Bagian / Divisi Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat <span class="required">*</span></label>
                            <input type="text" name="address" required class="form-control" readonly
                                value="{{ $profile->address }}" placeholder="Alamat">
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telp/HP <span class="required">*</span></label>
                            <input type="text" name="telp" required class="form-control" readonly
                                value="{{ $profile->phone }}" placeholder="Nomor Telepon / HP">
                        </div>
                        <h4>Dengan ini saya mengajukan Permohonan Pinjaman kepada Koperasi Simpan Pinjam (KSP)
                            PT. Warna Mandiri sebagai berikut:</h4>
                        <div class="form-group">
                            <label for="amount">Nominal Pinjaman <span class="required">*</span></label>
                            <input type="number" name="amount" id="amount" oninput="countLoanServiceAndTotal()" required
                                class="form-control" placeholder="Nomor Telepon / HP">
                        </div>
                        <div class="form-group">
                            <label for="loan_service">Jasa Pinjaman 1.5% <span class="required">*</span></label>
                            <input type="number" name="loan_service" id="loanService" required class="form-control"
                                placeholder="Jasa Pinjaman 1.5%" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Jumlah Total <span class="required">*</span></label>
                            <input type="number" name="total" id="total" required class="form-control"
                                placeholder="Jumlah Total" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Masukan berapa bulan rencana pelunasan peminjaman <span
                                    class="required">*</span></label>
                            <input type="number" oninput="countAngsuran()" name="total_month" id="total_month" required
                                class="form-control" placeholder="Contoh: 12">
                        </div>
                        <div class="form-group">
                            <label for="name">Angsuran/Bulan <span class="required">*</span></label>
                            <input type="hidden" name="installment_per_month" id="angsuran" required class="form-control"
                                placeholder="Masukan jumlah bulan diatas untuk melihat angsuran/bulan" readonly>
                            <p id="descAngsuran" style="font-weight: bold;">Silahkan masukan bulan diatas untuk melihat
                                jumlah angsuran per bulan</p>
                            <p id="displayAngsuran" style="font-weight: bold;"></p>
                        </div>
                        <div class="form-group">
                            <label for="name">Untuk Keperluan <span class="required">*</span></label>
                            <textarea name="description" required rows="3" required class="form-control"
                                placeholder="Jelaskan keperluan peminjaman"></textarea>
                        </div>
                        <h4>Aturan peminjaman sebagai berikut :</h4>
                        <ul>
                            <li>Metode pembayaran pinjaman dengan Potong Gaji.</li>
                            <li>Bersedia membayar cicilan pinjaman setiap bulannya kepada Koperasi Simpan Pinjam ( KSP ) PT.
                                Warna Mandiri.</li>
                            <li>Apabila terjadi sesuatu pada diri saya pada saat pinjaman belum lunas, maka yang akan
                                bertanggung jawab membayar pinjaman tersebut adalah suami/istri/anak saya yang sudah dewasa,
                                atau saya bersedia jika Koperasi Simpan Pinjam Warna Mandiri mengambil tindakan lain.</li>
                        </ul>
                        <div class="col-md-12">
                            <p>Silahkan tanda tangan dibawah ini!</p>
                            <canvas id="signature" width="450" height="150" style="border: 1px solid #ddd;"></canvas>
                            <button type="button" id="console"
                                style="background: transparent; border: none; color: rgb(12, 176, 12);"><i
                                    class="fa fa-check"></i></button>
                            <button type="button" id="clear" style="background: transparent; border: none; color: grey;"><i
                                    class="fa fa-trash"></i></button>
                        </div>
                        <input type="hidden" name="sign" id="sign"/>
                        <div class="form-check">
                            <input class="form-check-input" required type="checkbox" value="" id="tnc"
                                style="margin-left: 2px;">
                            <label class="form-check-label" for="tnc">
                                Dengan ini saya menyetujui aturan dan siap mengikuti aturan yang telah ditetapkan.
                            </label>
                        </div>
                        <div class="row">
                            <button type="submit"
                                onclick="return confirm('Pastikan data yang anda masukan sudah benar dan anda telah mengeklik tombol ceklist hijau pada samping papan tanda tangan!')"
                                class="btn btn-success w-100" style="margin-top: 15px">Ajukan
                                Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .required {
            color: red;
        }

    </style>
@endpush

@push('scripts')
    <script>
        function countAngsuran() {
            var month = 0;
            var angsuran = 0;
            var total = 0
            month = $('#total_month').val()
            total = $('#total').val()

            angsuran = parseInt(total) / parseInt(month)
            angsuran = Math.ceil(angsuran)
            $('#angsuran').val(angsuran)
            $('#descAngsuran').hide()
            if (angsuran > 0 && angsuran != '') {
                $('#displayAngsuran').text('Rp ' + numberWithCommas(angsuran) + '/Bulan')
            } else {
                $('#displayAngsuran').text('Silahkan masukan bulan diatas untuk melihat jumlah angsuran per bulan')
            }
        }

        function countLoanServiceAndTotal() {
            var amount = 0
            var service = 0
            var total = 0
            var tax = 0
            amount = $('#amount').val()
            tax = amount * 0.015
            service = tax > 0 ? Math.floor(tax) : 0
            total = parseInt(amount) + tax
            $('#loanService').val(service)
            $('#total').val(total)
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endpush


@push('styles')
    <link href="{{ asset('assets/css/jquery.signature.css') }}" rel="stylesheet" />
    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }

    </style>
@endpush

@push('scripts')
    {{-- <script type="text/javascript" src="{{ asset('assets/js/jquery.signature.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js">
    </script>

    <script>
        $(document).ready(function() {

            var canvas = document.getElementById("signature");
            var signaturePad = new SignaturePad(canvas, {
                syncField: '#sign'
            });

            $('#clear').on('click', function() {
                signaturePad.clear();
            });
            $('#console').on('click', function() {
                console.log(signaturePad.toDataURL())
                let sign = signaturePad.toDataURL()
                $('#sign').val(sign)
            });
        });
    </script>
@endpush
