@extends('../../../../templates/layouts')

@section('contents')
    <h1>Menu Pembayaran</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{route('officer.payments.angsuran')}}">
                <div id="menuCard" class="card card-chart"
                    style="border-radius: 25px; background: rgb(121,9,113);
                        background: linear-gradient(148deg, rgba(121,9,113,0.22460322019432777) 52%, rgba(0,212,255,1) 100%); ">
                    <div class="card-header">
                        <h3 class="card-title" style="padding: 75px;"><i class="tim-icons icon-money-coins text-primary"
                                style="font-size: 50px"></i> <span style="font-weight: 600">Angsuran</span></h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{route('officer.payments.simpanan')}}">
                <div id="menuCard" class="card card-chart"
                    style="border-radius: 25px; background: rgb(121,9,113);
                    background: linear-gradient(148deg, rgba(121,9,113,0.22460322019432777) 52%, rgba(0,212,255,1) 100%); ">
                    <div class="card-header">
                        <h3 class="card-title" style="padding: 75px;"><i class="tim-icons icon-coins text-secondary"
                                style="font-size: 50px"></i> <span style="font-weight: 600">Simpanan</span></h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #menuCard:hover {
            box-shadow: 4px 6px 7px -2px rgba(128, 128, 128, 0.42)
        }

    </style>
@endpush
