@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <h2>Angsuran Anggota</h2>
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="datatable1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>
                                        No Anggota
                                    </th>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Bulan
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installments as $item)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <td>
                                            {{ $item->loan->user->profile->code }}
                                        </td>
                                        <td>
                                            {{ $item->loan->user->profile->fullname }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            {{ date('F Y', strtotime($item->month . '-01')) }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
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
