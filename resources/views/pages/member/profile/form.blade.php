@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="title">Form Pendaftaran</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('member.post.form')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Masukan Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label>Bidang Pekerjaan</label>
                                    <input type="text" class="form-control" name="job_dept" placeholder="Masukan Bidang Pekerjaan">
                                </div>
                            </div>
                            <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label>Gaji Pokok</label>
                                    <input type="number" class="form-control" name="salary" placeholder="Masukan Gaji Pokok Anda">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No Telp/HP</label>
                                    <input type="number" class="form-control" name="phone" placeholder="Masukan nomor telepon / HP">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea rows="4" name="address" cols="80" class="form-control"
                                        placeholder="Masukan Alamat lengkap Anda"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-fill btn-primary">Simpan</button>
                    </form>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
