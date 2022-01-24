@extends('../../../../templates/layouts')

@section('contents')
    <h1>Setoran Simpanan</h1>
    <div class="row col-md-8 card" style="padding: 20px">
        @include('../../../../templates/flash')
        <div class="card-content">
            <form action="{{ route('officer.savings.store') }}" method="POST"> @csrf
                <div class="form-group">
                    <p style="font-size: 20px; font-weight: 600">Tipe Setoran</p>
                    <select name="type" id="type" class="form-control" onchange="getAmount({{ $members }})" required
                        style="padding: 10px;">
                        <option value="Pokok">Pokok</option>
                        <option value="Wajib">Wajib</option>
                        <option value="Sukarela">Sukarela</option>
                    </select>
                </div>
                <div class="form-group">
                    <p style="font-size: 20px; font-weight: 600">Nama Nasabah</p>
                    <select style="padding-top: 2px" id="select" onchange="getAmount({{ $members }})" required
                        aria-placeholder="Hahay" class="form-control js-example-basic-single" name="user_id">
                        @if (count($members) > 0)
                            <option selected>--Silahkan Pilih Nasabah--</option>
                        @endif
                        @forelse ($members as $item)
                            <option value="{{ $item->user_id }}"><b
                                    style="font-weight: 600 !important">{{ $item->code }}</b> {{ $item->fullname }}
                            </option>
                        @empty
                            <option>--Tidak Ditemukan Nasabah--</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <p style="font-size: 20px; font-weight: 600">Jumlah Setoran</p>
                    <input type="number" name="amount" id="amount" class="form-control" required
                        placeholder="Jumlah Setoran">
                    <div id="amount_text" style="font-weight: 600; margin-top: 10px;"></div>
                </div>
                <div style="float: right">
                    <button type="submit" onclick="return confirm('Pastikan data yang anda masukan benar. simpan?')"
                        class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        $('#amount').on('input', function() {
            var amount = $(this).val()
            if (amount != null) {
                $('#amount_text').text(`Rp. ${numberWithCommas(amount)}`);
            }
        })

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getAmount(members) {
            var value = $('#select').val();
            var con = $.grep(members, function(e) {
                return e.user_id == value;
            });
            var amount = 0;
            var type = $('#type').val()
            if (con.length > 0) {
                if (type) {
                    if (type == 'Pokok') {
                        amount = con[0]['saving_pokok']
                    } else if (type == 'Wajib') {

                        amount = con[0]['saving_wajib']
                    } else if (type == 'Sukarela') {
                        amount = con[0]['saving_sukarela']
                    }
                } else {
                    alert('Silahkan Pilih Tipe Setoran')
                }
            }
            $('#amount_text').text(`Rp. ${numberWithCommas(amount)}`);
            $('#amount').val(parseInt(amount))
        }
    </script>
@endpush
