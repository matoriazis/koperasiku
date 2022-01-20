@extends('../../../../templates/layouts')

@section('contents')
    <h2>Slip Transaksi</h2>
    <div class="row">
        <div class="col-md-8">
            @include('../../../../templates/flash')
            <div class="card" style="padding: 15px;">
                <form action="{{ route('member.slip.action') }}" method="POST">@csrf
                    <input type="hidden" name="id_user" value="{{ \Auth::user()->id }}">
                    <div class="form-group">
                        <label>Silahkan pilih bulan dibawah ini untuk melihat slip anda :</label>
                        <input type="month" name="start" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Lihat Slip</button>
                </form>
            </div>
        </div>
    </div>

    @if (isset($slip))
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="center"><b>SLIP KOPERASI</b></h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped" style="color: black">
                            <tbody>
                                <tr>
                                    <td>Nomor Anggota</td>
                                    <td>:</td>
                                    <td>{{ $slip['header']['code'] }}</td>
                                    <td class="right">Periode</td>
                                    <td>:</td>
                                    <td>{{ $slip['header']['periode'] }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $slip['header']['name'] }}</td>
                                    <td class="right">Bagian</td>
                                    <td>:</td>
                                    <td>{{ $slip['header']['dept'] }}</td>
                                </tr>
                                <tr>
                                    <td class="center" colspan="3"><b>Pendapatan</b></td>
                                    <td class="center" colspan="3"><b>Potongan</b></td>
                                </tr>
                                <tr>
                                    <td>Simpanan Pokok
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['incomes']['saving_pokok'], 2)}}
                                    </td>
                                    <td>Pot. Simpanan Pokok
                                    </td>
                                    <td style="width: 2px;">:</td>
                                    <td>Rp. {{number_format($slip['reductions']['saving_pokok'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Simpanan Wajib
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['incomes']['saving_wajib'], 2)}}
                                    </td>
                                    <td>Pot. Simpanan Wajib
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['reductions']['saving_wajib'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Simpanan Sukarela
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['incomes']['saving_sukarela'], 2)}}</td>
                                    <td>Pot. Simpanan Sukarela
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['reductions']['saving_sukarela'], 2)}}</td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Pot. Pinjaman 1 ( Angsuran )
                                    </td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['reductions']['installment'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Sisa Masa Pinjaman 1
                                    </td>
                                    <td>:</td>
                                    <td>{{$slip['incomes']['installment_remaining']}}x</td>
                                    <td>Jasa Pinjaman 1 ( Angsuran)</td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($slip['reductions']['loan_service'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="right"><b>Total Potongan</b></td>
                                    <td>Rp. {{number_format($slip['reductions']['total'], 2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <style>
        .right {
            text-align: right
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }
    </style>
@endpush