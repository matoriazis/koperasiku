@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <div class="col-md-8">
            @include('../../../../templates/flash')
            <div class="card">
                <div class="card-header">
                    <h2 class="title">Profile Saya</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.profile.update', ['id' => $profile->id]) }}" method="put">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" disabled value="{{\Auth::user()->name}}" name="fullname"
                                        placeholder="Masukan Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nomor KTP</label>
                                    <input type="number" class="form-control" disabled value="{{$profile->no_ktp}}" name="no_ktp"
                                        placeholder="Masukan No KTP Anda Sesuai Yang Tertera Pada Kartu Tanda Penduduk Anda">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tempat & Tanggal Lahir</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input disabled value="{{$profile->birth_place}}" type="text" class="form-control" name="birth_place"
                                                placeholder="Tempat Lahir">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" disabled value="{{$profile->birth_date}}" class="form-control" name="birth_date"
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bidang Pekerjaan</label>
                                    <input type="text" class="form-control" disabled value="{{$profile->job_dept}}" name="job_dept"
                                        placeholder="Masukan Bidang Pekerjaan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No Telp/HP</label>
                            <input type="number" class="form-control" required value="{{$profile->phone}}" name="phone"
                                placeholder="Masukan nomor telepon / HP">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea rows="4" name="address" cols="80" required class="form-control"
                                placeholder="Masukan Alamat lengkap Anda">{{$profile->address}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-fill btn-success w-100"
                        >Simpan Perubahan</button>
                    </form>
                </div>
                <div class="card-footer">
                    <p>* Anda dapat mengubah alamat dan nomor telepon anda dengan mengubah form diatas dan menekan tombol "Simpan Perubahan"</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function getTotal () {
            var sukarela = $('#saving_sukarela').val() != "" ? $('#saving_sukarela').val() : 0
            var wajib = $('#saving_wajib').val() != "" ? $('#saving_wajib').val() : 0
            var pokok = $('#saving_pokok').val() != "" ? $('#saving_pokok').val() : 0
            var total = parseInt(wajib) + parseInt(pokok) +parseInt(sukarela)
            $('#jumlah').val(total)
        }
    </script>
@endpush
