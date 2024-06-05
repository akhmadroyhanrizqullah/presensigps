<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request){

        $query = Siswa::query();
        $query->select('siswa.*','nama_dept');
        $query->join('departemen','siswa.kode_dept','=','departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_siswa)){
            $query->where('nama_lengkap','like','%'.$request->nama_siswa.'%');
        }
        if(!empty($request->kode_dept)){
            $query->where('siswa.kode_dept',$request->kode_dept);
        }
        $siswa=$query->paginate(5);

        $departemen = DB::table('departemen')->get();
        return view('siswa.index',compact('siswa','departemen'));
    }

    public function store(Request $request){
        $nis = $request->nis;
        $nama_lengkap = $request->nama_lengkap;
        $jurusan = $request->jurusan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        if($request->hasFile('foto')){
            $foto = $nis.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto=null;
        }

        try {
            $data=[
                'nis'=>$nis,
                'nama_lengkap'=>$nama_lengkap,
                'jurusan'=> $jurusan,
                'no_hp'=>$no_hp,
                'kode_dept'=>$kode_dept,
                'password'=>$password,
                'foto'=>$foto


            ];
            $simpan = DB::table('siswa')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/siswa/";
                    $request->file('foto')->storeAs($folderPath,$foto);
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data dengan NIS". $nis."Sudah Ada !";
            }
            return Redirect::back()->with(['warning'=>'Data Gagal Disimpan'. $message]);
        }
    }

    public function edit(Request $request){
        $nis = $request->nis;
        $departemen = DB::table('departemen')->get();
        $siswa = DB::table('siswa')->where('nis', $nis)->first();
       return view('siswa.edit', compact('departemen','siswa'));
    }

    public function update($nis, Request $request){
        $nis = $request->nis;
        $nama_lengkap = $request->nama_lengkap;
        $jurusan = $request->jurusan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;

        if($request->hasFile('foto')){
            $foto = $nis."_".time().".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto= $old_foto;
        }

        try {
            $data=[
                'nis'=>$nis,
                'nama_lengkap'=>$nama_lengkap,
                'jurusan'=> $jurusan,
                'no_hp'=>$no_hp,
                'kode_dept'=>$kode_dept,
                'password'=>$password,
                'foto'=>$foto


            ];
            $update = DB::table('siswa')->where('nis',$nis)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/siswa/";
                    $folderPathOld = "public/uploads/siswa/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath,$foto);
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
            }
        } catch (\Exception $e) {
            //throw $th;
            return Redirect::back()->with(['warning'=>'Data Gagal Diupdate']);
        }
    }

    public function delete($nis){
        $delete = DB::table('siswa')->where('nis',$nis)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Dihapus']);
        }
    }
}
