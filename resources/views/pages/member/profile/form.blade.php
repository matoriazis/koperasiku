@extends('../../../../templates/layouts')

@section('contents')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="title text-center">PERMOHONAN MASUK ANGGOTA KOPERASI</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.post.form') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{\Auth::user()->name}}" name="fullname" required
                                        placeholder="Masukan Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nomor KTP</label>
                                    <input type="number" class="form-control" name="no_ktp" required
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
                                            <input type="text" class="form-control" name="birth_place" required
                                                placeholder="Tempat Lahir">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" name="birth_date" required
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
                                    <input type="text" class="form-control" required name="job_dept" required
                                        placeholder="Masukan Bidang Pekerjaan">
                                </div>
                            </div>
                            {{-- <div class="col-md-6 pl-md-1">
                                <div class="form-group">
                                    <label>Gaji Pokok</label>
                                    <input type="number" class="form-control" name="salary" placeholder="Masukan Gaji Pokok Anda">
                                </div>
                            </div> --}}
                        </div>
                        <div class="form-group">
                            <label>No Telp/HP</label>
                            <input type="number" class="form-control" name="phone"
                                placeholder="Masukan nomor telepon / HP">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea rows="4" name="address" cols="80" class="form-control"
                                placeholder="Masukan Alamat lengkap Anda"></textarea>
                        </div>
                        <p>Dengan ini Saya mengajukan permohonan <b>Masuk</b> menjadi anggota Koperasi Simpan Pinjam ( KSP )
                            PT. WARNA MANDIRI, serta bersedia memenuhi ketentuan dan persyaratan yang ada yaitu: </p>
                        <div class="form-group">
                            <label>Simpanan Pokok</label>
                            <input type="number" id="saving_pokok" class="form-control" oninput="getTotal()" name="saving_pokok"
                                placeholder="Rp. ">
                        </div>
                        <div class="form-group">
                            <label>Simpanan Wajib (Setiap Bulan)</label>
                            <input type="number" id="saving_wajib" class="form-control" oninput="getTotal()" name="saving_wajib"
                                placeholder="Rp. ">
                        </div>
                        <div class="form-group">
                            <label>Simpanan Sukarela (Setiap Bulan)</label>
                            <input type="number" id="saving_sukarela" class="form-control" oninput="getTotal()" name="saving_sukarela"
                                placeholder="Rp. ">
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" id="jumlah" class="form-control" readonly name="total"
                                placeholder="Jumlah dari simpanan pokok, wajib dan sukarela (otomatis)">
                        </div>
                        
                        <p>        Demikian pengajuan permohonan Masuk koperasi Simpan Pinjam ( KSP )
                            PT WARNA MANDIRI Saya buat dengan sebenar benarnya dan bersedia mentaati, memahami serta
                            mematuhi aturan segala Hak dan Kewajiban sebagai anggota yang tertuang dalam Anggaran Dasar (AD)
                            / Anggaran Rumah Tangga (ART).
                        </p>

                        <div class="form-check">
                            <input class="form-check-input" required type="checkbox" value="" id="tnc"
                                style="margin-left: 2px;">
                            <label class="form-check-label" for="tnc">
                                Dengan ini saya setuju dan bersedia mengikuti peraturan dan kewajiban sebagai anggota koperasi.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-fill btn-success w-100"
                        onclick="return confirm('Pastikan data yang anda masukan sudah benar!')">Ajukan Permohanan
                        Anggota</button>
                    </form>
                </div>
                <div class="card-footer">
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
