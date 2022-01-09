@extends('../../../../templates/layouts')

@section('contents')
    <h2>Peminjaman</h2>
    <div class="row">
        <div class="col-md-12">
            @include('../../../../templates/flash')
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="card-title"> Daftar Peminjaman Anda</h4>
                        </div>
                        <div class="col-3" style="text-align: right">
                            <a href="{{ route('member.loans.create') }}" class="btn btn-success">Ajukan Peminjaman</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="datatable1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Keperluan
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                    <th>
                                        Angsuran
                                    </th>
                                    <th>
                                        Angsuran/Bulan
                                    </th>
                                    <th>
                                        Sisa Angsuran
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        Informasi Tambahan
                                    </th>
                                    <th>
                                        Opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $item->description ?? '-' }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->total_month }}x
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->installment_per_month, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->sisa_angsuran }}x
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            @if ($item->declined_reason != null && !$item->is_confirmed)
                                                <p style="font-weight: 600">Alasan Penolakan :</p>
                                                {{ $item->declined_reason }}
                                            @else
                                                <p style="font-weight: 600">Angsuran terakhir :</p>
                                                {{ $item->angsuran_terakhir }}

                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_confirmed)
                                                <a href="{{route('member.loans.show', ['id' => $item->id])}}" class="btn btn-primary btn-sm">Lihat Detail & Angsuran</a>
                                            @else
                                                Tidak Ada Opsi
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
