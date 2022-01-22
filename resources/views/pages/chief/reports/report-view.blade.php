<!DOCTYPE html>
<html lang="en">

<head>
    <title>LAPORAN DAFTAR TABUNGAN WAJIB DAN SUKARELA</title>
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

        .right {
            text-align: right
        }

        .left {
            text-align: left
        }

        table,
        th,
        td {
            border: 1px solid rgb(135, 135, 135);
            border-collapse: collapse;
            padding: 5px;
            font-family: Arial, Helvetica, sans-serif
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

        #listtable table {
            font-size: 11px;
        }
        #description table {
            font-size: 11px;
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
        <h4>LAPORAN DAFTAR TABUNGAN WAJIB DAN SUKARELA</h4>
    </div>
    <div class="row">
        <div class="col-12 center">
            <h5>TOTAL SHU:</h5>
            <h4 style="margin-top: -20px;">Rp. {{ number_format($total_shu, 2) }}</h4>
        </div>
    </div>
    <div id="description">
        <div class="row">
            <div class="col-8">
                <table>
                    <tr>
                        <th class="left">
                            Dana Sosial
                        </th>
                        <td>10%</td>
                        <td>Rp. {{ number_format($dana_sosial, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="left">
                            Dana Kematian
                        </th>
                        <td>10%</td>
                        <td>Rp. {{ number_format($dana_kematian, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="left">
                            Gaji Pengurus
                        </th>
                        <td>10%</td>
                        <td>Rp. {{ number_format($gaji_pengurus, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="right">Rp. {{ number_format($total_operasional, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <table>
                    <tr>
                        <th class="left">
                            Sisa SHU
                        </th>
                        <td>Rp. {{ number_format($sisa_shu, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="left">
                            Simpanan Wajib
                        </th>
                        <td>Rp. {{ number_format($simpanan_wajib, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="left">
                            Simpanan Sukarela
                        </th>
                        <td>Rp. {{ number_format($simpanan_sukarela, 2) }}</td>
                    </tr>
                    <tr>
                        <th>TOTAL S+W</th>
                        <td>Rp. {{ number_format($total_simpanan, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Prosentase</th>
                        <td>{{$prosentase}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="listtable">
        <table style="width: 100%">
            <thead width="100%">
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Nama</th>
                    <th>Tabungan Wajib</th>
                    <th>Tabungan Sukarela</th>
                    <th>Total</th>
                    <th>SHU Yang Didapat</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody style="width: 100%">
                @foreach ($detail_data as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item['name']}}</td>
                        <td>Rp. {{number_format($item['wajib'])}}</td>
                        <td>Rp. {{number_format($item['sukarela'])}}</td>
                        <td>Rp. {{number_format($item['total'])}}</td>
                        <td>Rp. {{number_format($item['shu_didapat'])}}</td>
                        <td>Rp. {{number_format($item['grand_total'])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <p style="font-size: 10px; text-align: right;">Laporan ini digenerate pada {{ date('Y/m/d H:i:s') }} oleh
            {{ \Auth::user()->name }}</p>
    </div>
</body>

</html>
