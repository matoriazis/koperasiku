@extends('../../../../../templates/layouts')

@section('contents')
    <h2>Peminjaman</h2>
    <div class="row">
        <div class="col-md-12">
            @include('../../../../templates/flash')
            <div class="card ">
                <div class="card-header">
                    <form action="{{ route('officer.loans.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="date">Bulan/Tahun</label>
                                <input type="month" class="form-control" name="month" value="{{$filter_date}}">
                            </div>
                            <div class="col-md-2">
                                <label for="Status">Status</label>
                                <select name="status" id="Status" class="form-control">
                                    @foreach ($status_list as $item)
                                        @if ($filter_status == $item['value'])
                                            <option value="{{ $item['value'] }}" selected>{{ $item['display'] }}</option>
                                        @else
                                            <option value="{{ $item['value'] }}">{{ $item['display'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="row" style="justify-content: left">
                                    <div class="col">
                                        <button style="margin-top: 23px" type="submit" class="btn btn-success">Filter</button>
                                    </div>
                                    <div class="col">
                                        <a style="margin-top: 23px" class="btn btn-secondary" href="{{route('officer.loans.index')}}">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
