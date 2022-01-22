<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Pemasukan Pengeluaran</title>
    {{-- <link rel="stylesheet" href="./style.css"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/> --}}
    <style>
        p,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: Arial, Helvetica, sans-serif
        }

        * {
            box-sizing: border-box;
        }

        .col-3 {
            float: left;
            width: 33.3333%;
            padding: 10px;
        }

        .col-2 {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .center {
            text-align: center
        }

        table,
        th,
        td {
            border: 1px solid rgb(135, 135, 135);
            border-collapse: collapse;
            padding: 5px;
        }

        thead,
        td {
            width: 100%
        }

        thead {
            background: grey;
            color: white
        }

        tr,
        td {
            padding: 5px !important;
        }

    </style>
</head>

<body>
    <div class="row" style="margin-bottom: 0px;">
        <div class="col-2" style="width: 15%">
            <img style="width: 100px" src="https://i.ibb.co/zP7RXyk/ksp.png" alt="">
        </div>
        <div class="col-2" style="width: 75%; text-align: center;">
            <h2>KOPERASI SIMPAN PINJAM (KSP)</h2>
            <h2 style="margin-top: -10px">PT WARNA MANDIRI</h2>
            <p style="font-size: 12px; text-align: center; margin-top: -10px; margin-bottom: 10px;">Jl.Cigintung No.3
                Rt. 01/ Rw. 05 Cangkorah, Batujajar, Kab. Bandung Barat – Jawa barat 40561</p>
        </div>
    </div>
    <hr>
    <div class="center">
        <h3>Laporan Pemasukan & Pengeluaran</h3>
        <p style="margin-top: -15px; font-size: 12px;">Periode {{$start}} - {{$end}}</p>
    </div>
    <div class="row">
        <div class="col-2 center">
            Pemasukan:
            <h1>Rp. {{ number_format($incomes, 2) }}</h1>
        </div>
        <div class="col-2 center">
            Pengeluaran:
            <h1>Rp. {{ number_format($outcomes, 2) }}</h1>
        </div>
    </div>
    <div>
        <h3>Adapun rinciannya sebagai berikut :</h3>
        <h4>Pemasukan :</h4>
        <table width="100%">
            <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Simpanan Pokok</td>
                    <td>
                        <h5>Rp. {{ number_format($income_detail['saving_pokok'], 2) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Simpanan Wajib</td>
                    <td>
                        <h5>Rp. {{ number_format($income_detail['saving_wajib'], 2) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Simpanan Sukarela</td>
                    <td>
                        <h5>Rp. {{ number_format($income_detail['saving_sukarela'], 2) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Angsuran Peminjaman</td>
                    <td>
                        <h5>Rp. {{ number_format($income_detail['angsuran'], 2) }}</h5>
                    </td>
                </tr>
            </tbody>
        </table>
        <h4>Pengeluaran :</h4>
        <table width="100%">
            <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Peminjaman Anggota</td>
                    <td>
                        <h5>Rp. {{ number_format($outcome_detail['loans'], 2) }}</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <p style="font-size: 10px; text-align: right;">Laporan ini digenerate pada {{date('Y/m/d H:i:s')}} oleh {{\Auth::user()->name}}</p>
    </div>
</body>

</html>
