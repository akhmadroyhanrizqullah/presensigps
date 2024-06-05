<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(){
        $departemen=DB::table('departemen')->orderBy('kode_dept')->get();
        $role=DB::table('roles')->orderBy('id')->get();
        $users = DB::table('users')
        ->select('users.id','users.name', 'email','nama_dept','roles.name as role')
            ->join('departemen', 'users.kode_dept', '=', 'departemen.kode_dept')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->get();
        return view('users.index',compact('users','departemen','role'));
    }

    public function store(Request $request){
    $nama_user = $request->nama_user;
    $email = $request->email;
    $kode_dept = $request->kode_dept;
    $role = $request->role;
    $password = bcrypt($request->password);

    DB::beginTransaction();
    try {
        //simpan data user dengan role
        $user = User::create([
            'name'=>$nama_user,
            'email'=>$email,
            'kode_dept'=>$kode_dept,
            'password'=>$password
        ]);

        $user->assignRole($role);
        DB::commit();
        return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
    } catch (\Exception $e) {
        dd($e);
        DB::rollBack();
        return Redirect::back()->with(['error'=>'Data Gagal Disimpan']);
    }
    }

    public function edit(Request $request){
        $id_user=$request->id_user;
        $departemen=DB::table('departemen')->orderBy('kode_dept')->get();
        $role=DB::table('roles')->orderBy('id')->get();
        $user=DB::table('users')
        ->join('model_has_roles','users.id','=','model_has_roles.model_id')
        ->where('id',$id_user)->first();
        return view('konfigurasi.edituser',compact('departemen','role','user'));
    }

    public function update(Request $request,$id_user){
    $nama_user = $request->nama_user;
    $email = $request->email;
    $kode_dept = $request->kode_dept;
    $role = $request->role;
    $password = bcrypt($request->password);

    if(isset($request->password)){
        $data =[
            'name'=>$nama_user,
            'email'=>$email,
            'kode_dept'=>$kode_dept,
            'password'=>$password
        ];
    }else{
        $data =[
            'name'=>$nama_user,
            'email'=>$email,
            'kode_dept'=>$kode_dept
        ];
    }

    DB::beginTransaction();
    try {
        //update data user.
        DB::table('users')->where('id',$id_user)
        ->update($data);

        //update data role.
        DB::table('model_has_roles')->where('model_id',$id_user)
        ->update([
            'role_id'=>$role
        ]);
        DB::commit();
        return Redirect::back()->with(['success'=>'Data Berhasil Diupdate']);
    } catch (\Exception $e) {
        dd($e);
        return Redirect::back()->with(['error'=>'Data Gagal Diupdate']);

    }
    }

    public function delete($id_user){
        try {
            DB::table('users')->where('id',$id_user)->delete();
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error'=>'Data Gagal Dihapus']);
        }
    }
}
