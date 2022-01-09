@extends('../../../../templates/layouts')

@section('contents')
    <h1>Bulanan</h1>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Pokok</h5>
                    <h3 class="card-title"><i class="tim-icons icon-money-coins text-primary"></i>
                        {{ $monthly['simpanan_pokok'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Wajib</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Rp.
                        {{ number_format($monthly['simpanan_wajib']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Simpanan Sukarela</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> Rp.
                        {{ number_format($monthly['simpanan_sukarela']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Pinjaman Aktif</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i>
                        {{ $monthly['loan_active'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Simpanan</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> Rp.
                        {{ number_format($monthly['simpanan_all']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Anggota</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> {{ $monthly['member'] }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <h1>Keseluruhan</h1>
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
@endsection
