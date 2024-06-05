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
        font-size: 10px;
    }
    .tabelpresensi tr td{
        border: 1px solid #000000;
        padding: 5px;
        font-size: 10px;

    }
    .foto{
        width: 80px;
        height: 90px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">
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
                    REKAP PRESENSI SISWA <br>
                    BULAN {{strtoupper($namabulan[$bulan])}} {{$tahun}}<br>
                    SMK NEGERI 1 BLEGA <br>

                </span>
                <span><i>Jln. Esemka NO.1, Kecamatan Blega</i></span>
            </td>

        </tr>
    </table>
    <table class="tabelpresensi">
        <tr>
            <th rowspan="2">NIS</th>
            <th rowspan="2">Nama Siswa</th>
            <th colspan="{{$jmlhari}}">Bulan {{$namabulan[$bulan]}}</th>
            <th rowspan="2">Total Hadir</th>
            <th rowspan="2">Total Telat</th>
        </tr>
        <tr>
            @foreach ($rangetanggal as $d )
            @if ($d!= NULL)
            <th>{{ date("d",strtotime($d)) }}</th>
            @endif
            @endforeach
        </tr>
        @foreach ($rekap as $r )
        <tr>
            <td>{{$r->nis}}</td>
            <td>{{$r->nama_lengkap}}</td>

            <?php
            $jml_hadir =0;
            $jml_telat = 0;
                for($i=1; $i<=$jmlhari; $i++){
                    $tgl = "tgl_".$i;
                    $datapresensi = explode("|",$r->$tgl);
                    $jam_in = $datapresensi[0];


            ?>
            <td>@if ($r->$tgl != NULL)
                {{($jam_in)}}
            @endif

            </td>
                <?php
                }
                ?>
            </td>

            <?php

            ?>
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
