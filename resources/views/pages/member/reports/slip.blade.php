@extends('../../../../templates/layouts')

@section('contents')
    <h2>Slip Anda</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="padding: 15px;">
                <form action="#">
                    <div class="form-group">
                        <label>Bulan</label>
                        <input type="month" name="start" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sampai Bulan</label>
                        <input type="month" name="end" class="form-control">
                    </div>
                    <button type="button" class="btn btn-success" onclick="return alert('belum release bos!')">Lihat Slip</button>
                </form>
            </div>
        </div>
    </div>
@endsection
