<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page { size: A4 }
    #title{
        font-size: 20px;
        font-weight: bold;
    }
    .tabeldatasiswa{
        margin-top: 40px;
    }
    .tabeldatasiswa td{
        padding: 5px;
    }
    .tabelpresensi{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    .tabelpresensi tr th{
        border: 1px solid #000000;
        padding: 8px;
        background-color: #808080;
    }
    .tabelpresensi tr td{
        border: 1px solid #000000;
        padding: 6px;

    }
    .foto{
        width: 80px;
        height: 90px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
<?php
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
?>
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    <table style="width:100%">
        <tr>
            <td style="width: 30px">
                <img src="{{asset('assets/img/logosmk.png')}}" width="100" height="100" alt="">
            </td>
            <td>
                <span id="title">
                    LAPORAN PRESENSI SISWA <br>
                    BULAN {{strtoupper($namabulan[$bulan])}} {{$tahun}}<br>
                    SMK NEGERI 1 BLEGA <br>

                </span>
                <span><i>Jln. Esemka NO.1, Kecamatan Blega</i></span>
            </td>

        </tr>
    </table>
    <table class="tabeldatasiswa">
        <tr>
            <td rowspan="5">
                @php
                    $path= Storage::url('uploads/siswa/'.$siswa->foto);
                @endphp
                <img src="{{url($path)}}" alt="" width="100" height="150">
            </td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td>{{$siswa->nis}}</td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>:</td>
            <td>{{$siswa->nama_lengkap}}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>:</td>
            <td>{{$siswa->jurusan}}</td>
        </tr>
        <tr>
            <td>Nomor Handphone</td>
            <td>:</td>
            <td>{{$siswa->no_hp}}</td>
        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>

            <th>Jam Pulang</th>

            <th>Keterangan</th>
        </tr>
        @foreach ($presensi as $d )
        @php

        $jamterlambat = selisih('07:00:00',$d->jam_in)
        @endphp

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{date("d-m-Y",strtotime($d->tgl_presensi))}}</td>
                <td>{{$d->jam_in}}</td>

                <td>{{$d->jam_out!=null?$d->jam_out:'Belum Absen'}}</td>

                <td>
                    @if ($d->jam_in>'07:00')
                    Terlambat {{$jamterlambat}}
                    @else
                    Tepat Waktu
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <table width="100%" style="margin-top: 100px">
        <tr>
            <td colspan="2" style="text-align: right">Blega, {{date('d-m-Y')}} <br>
                <i><b>Kepala Sekolah</b></i>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align:bottom" height="100px">
                <u>Akhmad Royhan</u><br>
                NIP. 200631100134
            </td>
        </tr>
    </table>
  </section>

</body>

</html>
