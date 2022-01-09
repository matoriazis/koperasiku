@extends('../../../../templates/layouts')

@section('contents')
    <h1>Pembayaran Angsuran</h1>
    <div class="row col-md-8 card" style="padding: 20px">
        @include('../../../../templates/flash')
        <div class="card-content">
            <form action="{{route('officer.payments.installment.store')}}" method="POST"> @csrf
                <div class="form-group">
                    <p style="font-size: 25px; font-weight: 600">Nama Nasabah</p>
                    <select style="padding-top: 2px" id="select" aria-placeholder="Hahay"
                        class="form-control js-example-basic-single" name="profile_id">
                        @if (count($members) > 0)
                            <option selected>--Silahkan Pilih Nasabah--</option>
                        @endif
                        @forelse ($members as $item)
                            <option value="{{ $item->id }}"><b
                                    style="font-weight: 600 !important">{{ $item->code }}</b> {{ $item->fullname }}
                            </option>
                        @empty
                            <option>--Tidak Ditemukan Nasabah--</option>
                        @endforelse
                    </select>
                </div>
                <div id="loading" style="transform: translateX(45%);margin-top: 25px; display: none;">Memuat</div>
                <div id="detail"></div>
                <div id="pembayaran"></div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

    <script>
        $('#select').on('change', function() {
            let id = $(this).val()
            console.log($(this).val());
            $('#loading').text('Memuat')
            $('#loading').show()
            $('#detail').empty();
            $('#pembayaran').empty();
            $.get(`/officer/payment/get-loans/${id}`, function(data, status) {
                let obj = data.data
                if (status === 'success') {
                    if (obj && obj.loans) {
                        $('#loading').hide()
                        let loans = obj.loans;
                        let html =
                            `
                                <input type="hidden" name="loan_id" value="${loans.id}">
                                <p style="font-size: 25px; font-weight: 600; margin-top: 25px;">Detail Peminjaman:</p>
                                <div><p style="font-size: 14px; font-weight: 600;">No Anggota : </p> ${loans.user.profile.code}</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Atas Nama : </p> ${loans.user.name}</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Jumlah Peminjaman : </p> Rp. ${loans.amount}</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Angsuran/Bulan : </p> Rp. ${loans.installment_per_month}</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Sisa Angsuran : </p> ${loans.sisa_angsuran}x</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Angsuran Terakhir pada : </p> ${loans.angsuran_terakhir}</div>
                                <div><p style="font-size: 14px; font-weight: 600;">Tanggal Peminjaman : </p> ${loans.confirmed_at}</div>
                            `;
                        $('#detail').append(html)
                        $('#pembayaran').append(
                            `
                            <div style="border: 1px striped"></div>
                            <div class="form-group">
                                <p for="month" style="font-size: 25px; font-weight: 600">Pembayaran untuk bulan</p>
                                <input type="month" class="form-control" name="month" required value="<?= date('Y-m') ?>"></div>
                            <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                            <p style="text-decoration: italic; color: grey;">*Sebelum menekan tombol diatas, pastikan anda telah menerima angsuran dari nasabah.</p>
                        `);
                    } else {
                        $('#loading').text('Tidak Ditemukan Peminjaman')
                    }
                }
            })
        })
    </script>
@endpush
