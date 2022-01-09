@extends('../../../../templates/layouts')

@section('contents')
    <h2>Detail Peminjaman</h2>
    <div class="row">
        <div class="col-md-12">
            @include('../../../../templates/flash')
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <h5>Jumlah Pinjaman: </h5>
                                <h3>Rp. {{ number_format($loan->amount) }}</h3>
                            </div>
                            <div>
                                <h5>Angsuran/Bulan: </h5>
                                <h3>Rp. {{ number_format($loan->installment_per_month) }}</h3>
                            </div>
                            <div>
                                <h5>Sisa Angsuran: </h5>
                                <h3>{{ $loan->sisa_angsuran }}x dari {{$loan->total_month}}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <h5>Keperluan: </h5>
                                <h3>{{ $loan->description }}</h3>
                            </div>
                            <div>
                                <h5>Tanggal Pengajuan: </h5>
                                <h3>{{ date('d F Y', strtotime($loan->created_at)) }}</h3>
                            </div>
                            <div>
                                <h5>Tanggal Diterima: </h5>
                                <h3>{{ date('d F Y', strtotime($loan->confirmed_at)) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2>Angsuran</h2>
    <div class="row">
        <div class="col-md-12">
            @include('../../../../templates/flash')
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="datatable1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Bulan
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loan->installments as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ date('F Y', strtotime($item->month . '-01')) }}
                                        </td>
                                        <td>
                                            {{ $item->amount ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Belum ada angsuran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
