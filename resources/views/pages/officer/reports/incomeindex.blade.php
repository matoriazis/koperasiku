@extends('../../../../templates/layouts')

@section('contents')
    <h2>Laporan Pemasukan & Pengeluaran</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="padding: 15px;">
                <form action="{{route('officer.report.in.outcome')}}" method="POST" target="_blank"> @csrf
                    <div class="form-group">
                        <label>Bulan</label>
                        <input type="month" name="start" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sampai Bulan</label>
                        <input type="month" name="end" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Kirim </button>
                </form>
            </div>
        </div>
    </div>
@endsection
