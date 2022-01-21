@extends('../../../../templates/layouts')

@section('contents')
    <h2>Report SHU</h2>
    <div class="row">
        <div class="col-md-6">
            @include('../../../../templates/flash')
            <div class="card" style="padding: 15px;">
                <form action="{{ route('chief.detailed.shu') }}" method="POST">@csrf
                    <input type="hidden" name="id_user" value="{{ \Auth::user()->id }}">
                    <div class="form-group">
                        <label>Silahkan masukan tahun dibawah ini untuk melihat SHU koperasi :</label>
                        <input type="number" max="{{date('Y')}}" min="{{date('Y') - 5}}" required name="year" placeholder="Masukan Tahun SHU" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Rincian SHU</button>
                </form>
            </div>
        </div>
    </div>

    @if (isset($detail_shu))
        <div class="card">
            <div class="card-header">
                <h3><b>Rincian SHU</b></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>NO</th>
                        <th>NAMA</th>
                        @foreach ($list_month as $month)
                            <th>{{$month['label']}}</th>
                        @endforeach
                        <th>TOTAL</th>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0 @endphp
                        @foreach ($detail_shu as $detail)
                            @php $rowTotal = 0 @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$detail['name']}}</td>
                                @foreach ($detail['data'] as $item)
                                    @if ($item['total'])
                                        @php $rowTotal += $item['total'] @endphp
                                    <td>{{number_format($item['total'])}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                                <td>{{number_format($rowTotal)}}</td>
                            </tr>
                            @php $grandTotal += $rowTotal @endphp
                        @endforeach
                            <tr>
                                <th colspan="14" class="right">Total</th>
                                <th>{{number_format($grandTotal)}}</th>
                            </tr>
                    </tbody>
                </table>
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