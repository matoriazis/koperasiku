@extends('../../../../../templates/layouts')

@section('contents')
    <h2>Peminjaman</h2>
    <div class="row">
        <div class="col-md-12">
            @include('../../../../templates/flash')
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <h4 class="card-title"> Konfirmasi Peminjaman Anggota</h4>
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
                                        Nama Peminjam</span>
                                    </th>
                                    <th>
                                        Keperluan
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                    <th>
                                        Total Bulan
                                    </th>
                                    <th>
                                        Angsuran/Bulan
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        Info
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
                                            {{ $item->user->profile->fullname }} <br> <span
                                                style="font-weight: bold; font-size: 10px;">#{{ $item->user->profile->code }}
                                        </td>
                                        <td>
                                            {{ $item->description ?? '-' }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->total_month }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->installment_per_month, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                                        </td>
                                        <td>
                                            <div
                                                style="background: white; box-shadow: 1px 1px 10px rgb(174, 174, 174); padding: 10px; border-radius: 15px">
                                                <p>Simpanan Member (Wajib+Sukarela) :
                                                    Rp.<b>{{ number_format($item->total_savings) }}</b></p>
                                                <p>Max Pinjaman (2X (Wajib+Sukarela)) :
                                                    <b>Rp.{{ number_format($item->total_savings * 2) }}</b>
                                                </p>
                                                <hr>
                                                <p>Tanda Tangan :</p>
                                                @if ($item->signature)
                                                    <img width="150px" src="{{ url($item->signature) }}"
                                                        alt="TTD Anggota">
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm"
                                                onclick="OnAccept({{ $item->id }})">Konfirmasi</button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="OnReject({{ $item->id }})">Tolak</button>
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

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Masukan Alasan Penolakan Pengajuan Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('chief.confirm.loan.action') }}" method="POST">@csrf
                        <input type="hidden" id="cancel_id" name="id">
                        <input type="hidden" name="action" value="rejected">
                        <div class="form-group">
                            <textarea name="cancelation_note" placeholder="Masukan alasan disini.." class="form-control"
                                rows="5"></textarea>
                        </div>
                        <div style="text-align: right">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Tolak Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Konfirmasi Pengjauan --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('chief.confirm.loan.action') }}" method="POST">@csrf
                        <h2>Konfirmasi Pengajuan Peminjaman?</h2>
                        <input type="hidden" id="confirm_id" name="id">
                        <input type="hidden" name="action" value="confirmed">
                        <div class="row" style="justify-content: right">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success btn-sm">Konfirmasi Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function OnReject(id) {
            $('#cancel_id').val(id)
            $('#rejectModal').modal('show');
        }

        function OnAccept(id) {
            $('#confirm_id').val(id)
            $('#confirmModal').modal('show');
        }
    </script>
@endpush
