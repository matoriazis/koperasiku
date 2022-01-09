@extends('../../../../templates/layouts')

@section('contents')
    <h1>Simpanan Wajib</h1>
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('officer.savings.index', ['type' => 'wajib']) }}">
                <div class="card cardMenu active">
                    <span>Simpanan Wajib</span>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('officer.savings.index', ['type' => 'pokok']) }}">
                <div class="card cardMenu">
                    <span>Simpanan Pokok</span>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('officer.savings.index', ['type' => 'sukarela']) }}">
                <div class="card cardMenu">
                    <span>Simpanan Sukarela</span>
                </div>
            </a>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="datatable1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                    <th>
                                        Deskripsi
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
                                @foreach ($savings as $item)
                                    <tr>
                                        <td>
                                            {{ $item->user->name }}
                                        </td>
                                        <td>
                                            Rp. {{ number_format($item->amount, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->description ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
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

@push('styles')
    <style>
        .cardMenu {
            border-radius: 25px;
            margin: auto;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
            padding: 10px;

        }

        .cardMenu:hover {
            transition: ease-out 0.3s;
            font-size: 15.5px;
            box-shadow: 1px 4px 20px rgba(123, 123, 123, 0.211)
        }

        .active {
            background: blueviolet !important;
            color: white;
        }

    </style>
@endpush
