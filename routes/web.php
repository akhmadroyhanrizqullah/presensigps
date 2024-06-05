<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//login siswa
route::middleware(['guest:siswa'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin',[AuthController::class, 'proseslogin']);
});

//login admin
route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin',[AuthController::class, 'prosesloginadmin']);
});



//middleware siswa
Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index']);
    Route::get('/proseslogout',[AuthController::class, 'proseslogout']);

    //presensi
    Route::get('/presensi/create',[PresensiController::class, 'create']);
    Route::post('/presensi/store',[PresensiController::class,'store']);

    //editprofile
    Route::get('/editprofile',[PresensiController::class,'editprofile']);
    Route::post('/presensi/{nis}/updateprofile',[PresensiController::class,'updateprofile']);

    //histori
    Route::get('/presensi/histori',[PresensiController::class,'histori']);
    Route::post('/gethistori',[PresensiController::class,'gethistori']);

    //izin
    Route::get('/presensi/izin',[PresensiController::class,'izin']);
    Route::get('/presensi/buatizin',[PresensiController::class,'buatizin']);
    Route::post('/presensi/storeizin',[PresensiController::class,'storeizin']);
    Route::post('/presensi/cekpengajuanizin',[PresensiController::class,'cekpengajuanizin']);
});

//route yang bisa diakses oleh admin dari admin departemen
Route::group(['middleware' => ['role:admin|admin departemen,user']], function () {
    Route::get('/proseslogoutadmin',[AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin',[DashboardController::class,'dashboardadmin']);

    //data siswa
    Route::get('/siswa',[SiswaController::class,'index']);

    //monitoring
    Route::get('/presensi/monitoring',[PresensiController::class,'monitoring']);
    Route::post('/getpresensi',[PresensiController::class,'getpresensi']);
    Route::post('/tampilkanpeta',[PresensiController::class,'tampilkanpeta']);

    //laporan
    Route::get('/presensi/laporan',[PresensiController::class,'laporan']);
    Route::post('/presensi/cetaklaporan',[PresensiController::class,'cetaklaporan']);
    Route::get('/presensi/rekap',[PresensiController::class,'rekap']);
    Route::post('/presensi/cetakrekap',[PresensiController::class,'cetakrekap']);

    //izin sakit
    Route::get('/presensi/izinsakit',[PresensiController::class,'izinsakit']);

});

//middleware admin
//Route yang hanya bisa di akses oleh administrator
Route::group(['middleware' => ['role:admin,user']], function () {


    //master data siswa

    Route::post('/siswa/store',[SiswaController::class,'store']);
    Route::post('/siswa/edit',[SiswaController::class,'edit']);
    Route::post('/siswa/{nis}/update',[SiswaController::class,'update']);
    Route::post('/siswa/{nis}/delete',[SiswaController::class,'delete']);


    //Departemen
    Route::get('/departemen',[DepartemenController::class,'index'])->middleware('permission:view-departemen,user');
    Route::post('/departemen/store',[DepartemenController::class,'store']);
    Route::post('/departemen/edit',[DepartemenController::class,'edit']);
    Route::post('/departemen/{kode_dept}/update',[DepartemenController::class,'update']);
    Route::post('/departemen/{kode_dept}/delete',[DepartemenController::class,'delete']);

    //Monitoring



    //laporan


    //izin sakit
    Route::post('/presensi/approveizinsakit',[PresensiController::class,'approveizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit',[PresensiController::class,'batalkanizinsakit']);

    //konfigurasi
    Route::get('/konfigurasi/users',[UserController::class,'index']);
    Route::post('/konfigurasi/users/store',[UserController::class,'store']);
    Route::post('/konfigurasi/users/edit',[UserController::class,'edit']);
    Route::post('/konfigurasi/users/{id_user}/update',[UserController::class,'update']);
    Route::post('/konfigurasi/users/{id_user}/delete',[UserController::class,'delete']);

});

Route::get('/createrolepermission',function(){
    try {
        Role::create(['name' => 'admin departemen']);
        // Permission::create(['name' => 'view-siswa']);
        // Permission::create(['name' => 'view-departemen']);
        echo"Success";
    } catch (\Exception $e) {
        echo"Error";
    }
});

Route::get('/give-user-role', function () {
    try {
        $user = User::findorfail(1);
        $user->assignRole(2);
        echo"Sukses";
    } catch (\Throwable $th) {
        echo"Gagal";
    }
});

Route::get('/give-role-permission', function () {
    try {
        $role= Role::findorfail(2);
        $role->givePermissionTo(2);
        echo"Sukses";
    } catch (\Throwable $th) {
        echo"Gagal";
    }
});
