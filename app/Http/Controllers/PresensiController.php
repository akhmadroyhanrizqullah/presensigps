<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create(){

        $nis = Auth::guard('siswa')->user()->nis;
        $tgl_presensi = date("Y-m-d");
        $cek = DB::table('presensi')->where('nis', $nis)->where('tgl_presensi', $tgl_presensi)->count();
        return view ('presensi.create',compact('cek'));
    }
    public function store (Request $request){
        $nis = Auth::guard('siswa')->user()->nis;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];


        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $latitudekantor = -7.1351534;
        $longitudekantor = 112.716362;
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser,$longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')->where('nis', $nis)->where('tgl_presensi', $tgl_presensi)->count();
        if($cek > 0){
            $ket = "out";
        }else {
            $ket = "in";
        }
        $format = $nis . "-" . $tgl_presensi."-".$ket;
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";

        $image_parts = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $format . ".png";
        $file = $folderPath . $fileName;

        if($radius > 10){
            echo "error| Maaf Anda Berada Diluar Radius " .$radius." meter dari Sekolah|";
        }else{
        if($cek > 0){
            $data_out =[
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('presensi')
                -> where ('nis', $nis)
                -> where ('tgl_presensi', $tgl_presensi)
                -> update($data_out);
            if($update){
                echo "success|Terimakasih telah melakukan Absen Pulang, Hati hati dijalan|out";
                Storage::put($file, $image_base64);
            }else{
                echo "error|Maaf Gagal Absen, Hubungi Tim It|out";
            }
        }else {
            $data_in =[
                'nis'           => $nis,
                'tgl_presensi'  => $tgl_presensi,
                'jam_in'        => $jam,
                'foto_in'       =>$fileName,
                'lokasi_in'     =>$lokasi
            ];
            $simpan = DB::table('presensi')->insert($data_in);
            if($simpan){
                echo "success|Terimakasih telah melakukan Absen masuk, selamat minimbah ilmu|in";
                Storage::put($file, $image_base64);
            }else{
                echo "error|Maaf Gagal Absen, Hubungi Tim It|in";
            }

        }

    }
}

//Menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2){
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1))*sin(deg2rad($lat2))) + (cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles*60*1.1515;
        $feet = $miles*5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
     public function editprofile(){
        $nis = Auth::guard('siswa')->user()->nis;
        $siswa = DB::table('siswa')->where('nis', $nis)->first();
        return view ('presensi.editprofile', compact('siswa'));
     }
     public function updateprofile($nis, Request $request){
        $nis = Auth::guard('siswa')->user()->nis;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $siswa = DB::table('siswa')->where('nis', $nis)->first();

        if($request->hasFile('foto')){
            $foto = $nis.".".time().".".$request->file('foto')->getClientOriginalExtension();
            if(!empty($siswa->foto)){
                Storage::delete("public/uploads/siswa/{$siswa->foto}");
            }
        }else{
            $foto=$siswa->foto;
        }

        if(empty($request->password)){
            $data = [
                'nama_lengkap'=>$nama_lengkap,
                'no_hp'=>$no_hp,
                'foto'=>$foto
            ];
        }else{
            $data = [
            'nama_lengkap'=>$nama_lengkap,
            'no_hp'=>$no_hp,
            'password'=>$password,
            'foto'=>$foto
        ];
        }
        $update=DB::table('siswa')->where('nis',$nis)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/siswa/";
                $request->file('foto')->storeAs($folderPath,$foto);
            }
            return Redirect::back()->with(['success'=>'Data Berhasil di Update']);
        }else{
            return Redirect::back()->with(['error'=>'Data Gagal di Update']);
        }
     }

     public function histori(){
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","juli","Agustus","September","Oktober","November","Desember"];
        return view('presensi.histori',compact('namabulan'));
     }

     public function gethistori(Request $request){
        $bulan=$request->bulan;
        $tahun=$request->tahun;
        $nis= Auth::guard('siswa')->user()->nis;

        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('nis', $nis)
        ->orderBy('tgl_presensi')
        ->get();

      return view('presensi.gethistori',compact('histori'));
     }
     public function izin(){
        $nis = Auth::guard('siswa')->user()->nis;
        $dataizin = DB::table('pengajuan_izin')->where('nis',$nis)->get();
        return view('presensi.izin',compact('dataizin'));
     }
     public function buatizin(){

        return view('presensi.buatizin');
     }
     public function storeizin(Request $request){
        $nis=Auth::guard('siswa')->user()->nis;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data=[
            'nis'=>$nis,
            'tgl_izin'=>$tgl_izin,
            'status'=>$status,
            'keterangan'=>$keterangan
        ];
        $simpan = DB::table('pengajuan_izin')->insert($data);
        if($simpan){
            return redirect('/presensi/izin')->with(['success'=>'Data Berhasil Disimpan']);
        }else{
            return redirect('/presensi/izin')->with(['error'=>'Data Gagal Disimpan']);
        }
     }

     public function monitoring(){
        return view('presensi.monitoring');
     }

     public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap','nama_dept')
        ->join('siswa','presensi.nis','=','siswa.nis')
        ->join('departemen','siswa.kode_dept','=','departemen.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi',compact('presensi'));
     }

     public function tampilkanpeta(Request $request){
        $id = $request->id;
        $presensi = DB::table('presensi')
        ->where('id', $id)
        ->join('siswa','presensi.nis','=','siswa.nis')
        ->first();
        return view('presensi.showmap',compact('presensi'));
     }

        public function laporan(){
            $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","juli","Agustus","September","Oktober","November","Desember"];
            $siswa = DB::table('siswa')
            ->orderBy('nama_lengkap')
            ->get();
            return view('presensi.laporan',compact('namabulan','siswa'));
        }

        public function cetaklaporan(Request $request){
            $nis = $request->nis;
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","juli","Agustus","September","Oktober","November","Desember"];
            $siswa=DB::table('siswa')
            ->where('nis',$nis)
            ->first();
            $presensi = DB::table('presensi')
            ->where('nis',$nis)
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();
            if(isset($_POST['exportexcel'])){
                $time = date("d-M-Y H:i:s");
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition:attachment; filename=Laporan Presensi Siswa $time.xls");
                return view('presensi.cetaklaporanexcel',compact('bulan','tahun','namabulan','siswa','presensi'));
            }
            return view('presensi.cetaklaporan',compact('bulan','tahun','namabulan','siswa','presensi'));
        }

        public function rekap(){
            $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","juli","Agustus","September","Oktober","November","Desember"];
            $departemen = DB::table('departemen')
            ->get();
            return view('presensi.rekap',compact('namabulan','departemen'));
        }
        public function cetakrekap(Request $request){
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $dari = $tahun . "-" . $bulan . "-01";
            $sampai = date("Y-m-t", strtotime($dari));
            $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            $rangetanggal = [];
            while(strtotime($dari) <= strtotime($sampai)){
                $rangetanggal[] = $dari;
                $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
            }

            $jmlhari = count($rangetanggal);
            $lastrange = $jmlhari -1;
            $sampai = $rangetanggal[$lastrange];
            if($jmlhari==30){
                array_push($rangetanggal,NULL);
            }elseif($jmlhari==29){
                array_push($rangetanggal,NULL, NULL);
            }elseif($jmlhari==28){
                array_push($rangetanggal,NULL,NULL,NULL);
            }

            $query = Siswa::query();
            $query->selectRaw(
                "siswa.nis, nama_lengkap, jurusan,
                tgl_1,
                tgl_2,
                tgl_3,
                tgl_4,
                tgl_5,
                tgl_6,
                tgl_7,
                tgl_8,
                tgl_9,
                tgl_10,
                tgl_11,
                tgl_12,
                tgl_13,
                tgl_14,
                tgl_15,
                tgl_16,
                tgl_17,
                tgl_18,
                tgl_19,
                tgl_20,
                tgl_21,
                tgl_22,
                tgl_23,
                tgl_24,
                tgl_25,
                tgl_26,
                tgl_27,
                tgl_28,
                tgl_29,
                tgl_30,
                tgl_31"
            );

            $query ->leftJoin(


                DB::raw("(
                    SELECT presensi.nis,
                    MAX(IF(tgl_presensi = '$rangetanggal[0]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_1,
                    MAX(IF(tgl_presensi = '$rangetanggal[1]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_2,
                    MAX(IF(tgl_presensi = '$rangetanggal[2]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_3,
                    MAX(IF(tgl_presensi = '$rangetanggal[3]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_4,
                    MAX(IF(tgl_presensi = '$rangetanggal[4]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_5,
                    MAX(IF(tgl_presensi = '$rangetanggal[5]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_6,
                    MAX(IF(tgl_presensi = '$rangetanggal[6]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_7,
                    MAX(IF(tgl_presensi = '$rangetanggal[7]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_8,
                    MAX(IF(tgl_presensi = '$rangetanggal[8]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_9,
                    MAX(IF(tgl_presensi = '$rangetanggal[9]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_10,
                    MAX(IF(tgl_presensi = '$rangetanggal[10]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_11,
                    MAX(IF(tgl_presensi = '$rangetanggal[11]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_12,
                    MAX(IF(tgl_presensi = '$rangetanggal[12]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_13,
                    MAX(IF(tgl_presensi = '$rangetanggal[13]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_14,
                    MAX(IF(tgl_presensi = '$rangetanggal[14]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_15,
                    MAX(IF(tgl_presensi = '$rangetanggal[15]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_16,
                    MAX(IF(tgl_presensi = '$rangetanggal[16]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_17,
                    MAX(IF(tgl_presensi = '$rangetanggal[17]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_18,
                    MAX(IF(tgl_presensi = '$rangetanggal[18]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_19,
                    MAX(IF(tgl_presensi = '$rangetanggal[19]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_20,
                    MAX(IF(tgl_presensi = '$rangetanggal[20]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_21,
                    MAX(IF(tgl_presensi = '$rangetanggal[21]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_22,
                    MAX(IF(tgl_presensi = '$rangetanggal[22]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_23,
                    MAX(IF(tgl_presensi = '$rangetanggal[23]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_24,
                    MAX(IF(tgl_presensi = '$rangetanggal[24]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_25,
                    MAX(IF(tgl_presensi = '$rangetanggal[25]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_26,
                    MAX(IF(tgl_presensi = '$rangetanggal[26]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_27,
                    MAX(IF(tgl_presensi = '$rangetanggal[27]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_28,
                    MAX(IF(tgl_presensi = '$rangetanggal[28]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_29,
                    MAX(IF(tgl_presensi = '$rangetanggal[29]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_30,
                    MAX(IF(tgl_presensi = '$rangetanggal[30]', CONCAT(IFNULL(jam_in, 'NA'), '|', IFNULL(jam_out, 'NA'), '|'), NULL)) as tgl_31
                    FROM presensi
                    WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                    GROUP BY nis
                )presensi"),
                function($join){
                    $join->on('siswa.nis','=','presensi.nis');
                }
                );

            $query->orderBy('nama_lengkap');
            $rekap = $query->get();
            // dd($rekap);

            if ($request->has('exportexcel')) {
                $time = date("d-M-Y H:i:s");
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Rekap Presensi Siswa $time.xls");
            }

            return view('presensi.cetakrekap', compact('bulan', 'tahun', 'namabulan', 'rekap', 'jmlhari', 'rangetanggal'));
        }



        public function izinsakit(Request $request){

            $query = Pengajuanizin::query();
            $query->select('id','tgl_izin','pengajuan_izin.nis','nama_lengkap','jurusan','status','status_approved','keterangan');
            $query->join('siswa','pengajuan_izin.nis','=','siswa.nis');
            if(!empty($request->dari)&& !empty($request->sampai)){
                $query->whereBetween('tgl_izin',[$request->dari, $request->sampai]);
            }
            if(!empty($request->nis)){
                $query->where('pengajuan_izin.nis',$request->nis);
            }
            if(!empty($request->nama_lengkap)){
                $query->where('nama_lengkap','like','%'. $request->nama_lengkap.'%');
            }
            if($request->status_approved==='0'|| $request->status_approved==='1'||$request->staus_approved==='2'){
                $query->where('status_approved',$request->status_approved);
            }
            $query->orderBy('tgl_izin','desc');
            $izinsakit = $query->paginate(5);
            $izinsakit -> appends($request->all());
            return view('presensi.izinsakit', compact('izinsakit'));
        }

        public function approveizinsakit(Request $request){
            $status_approved = $request->status_approved;
            $id_izinsakit_form = $request->id_izinsakit_form;
            $update = DB::table('pengajuan_izin')
            ->where('id',$id_izinsakit_form)
            ->update([
                'status_approved'=>$status_approved
            ]);
            if($update){
                return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
            }else{
                return Redirect::back()->with(['success'=>'Data Gagal Diupdate']);
            }
        }
        public function batalkanizinsakit($id){
            $update = DB::table('pengajuan_izin')
            ->where('id',$id)
            ->update([
                'status_approved'=>0
            ]);
            if($update){
                return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
            }else{
                return Redirect::back()->with(['success'=>'Data Gagal Diupdate']);
            }
        }

        public function cekpengajuanizin(Request $request){
            $tgl_izin = $request->tgl_izin;
            $nis = Auth::guard('siswa')->user()->nis;
            $cek = DB::table('pengajuan_izin')->where('nis', $nis)->where('tgl_izin',$tgl_izin)->count();
            return $cek;
        }
}
