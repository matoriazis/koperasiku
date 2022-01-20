@extends('../../../../templates/layouts')

@section('contents')
    @include('../../../../templates/flash')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Pokok</h5>
                    <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i>
                        {{ $count['simpanan_pokok'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Wajib</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Rp.
                        {{ number_format($count['simpanan_wajib']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Sukarela</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> Rp.
                        {{ number_format($count['simpanan_sukarela']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Pinjaman Aktif</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i>
                        {{ $count['loan_active'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Simpanan</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> Rp.
                        {{ number_format($count['simpanan_all']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Anggota</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> {{ $count['member'] }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title"> Konfirmasi Pembayaran Awal Anggota</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
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
                                        Tanggal
                                    </th>
                                    <th>
                                        Bukti Pembayaran
                                    </th>
                                    <th class="text-center">
                                        Opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $item)
                                    <tr>
                                        <td>
                                            {{ $item->user->name }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            @if ($item->path_to_file)
                                                <a href="{{ url($item->path_to_file) }}" target="_blank" title="Klik untuk memperbesar">
                                                    <img width="100px" src="{{ url($item->path_to_file) }}"
                                                        alt="Bukti Pembayaran IMG">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('officer.action.payment', ['id' => $item->id]) . '?action=confirm' }}"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Yakin ingin meng-konfirmasi pengajuan ini?')">Konfirmasi</a>
                                            <a href="{{ route('officer.action.payment', ['id' => $item->id]) . '?action=decline' }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menolak pengajuan ini?')">Tolak</a>
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
