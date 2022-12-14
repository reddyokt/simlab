<?php

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatsController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PraktikumController;
use App\Http\Controllers\inventory\AlatController;
use App\Http\Controllers\inventory\BahanController;
use App\Http\Controllers\praktikan\AbsenController;
use App\Http\Controllers\praktikan\TugasController;
use App\Http\Controllers\inventory\BarangController;
use App\Http\Controllers\praktikan\JadwalController;
use App\Http\Controllers\praktikan\PesertaController;

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

//----------------------------------Landing-------------------------------------//
Route::get('/', [LandingController::class, 'index']);


//-----------------------------------Pendaftaran--------------------------------//
Route::get('/daftarPraktikum', [DaftarController::class, 'daftar']);
Route::post('/daftarPraktikum', [DaftarController::class, 'store']);
Route::post('/setuju/{id_pendaftaran}', [DaftarController::class, 'setuju']);

Route::get('/findnamamhs', 'DaftarController@findnamamhs');
Route::get('/findNim', 'DaftarController@findNim');





//-----------------------------------Login-Dashboard---------------------------------//
Route::get('/login',[LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');


//----------------------------------User-------------------------------------//
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/create', [UserController::class, 'create']);
Route::post('/user/create', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/edit/{id}', [UserController::class, 'edit']);
Route::get('/delete/{id}', [UserController::class, 'delete']);

Route::get('/dosen', [DosenController::class, 'index']);
Route::get('/dosen/create', [DosenController::class, 'create']);
Route::post('/dosen/create', [DosenController::class, 'store']);
Route::get('/dosen/{id}', [DosenController::class, 'show']);
Route::post('/edit/{id}', [DosenController::class, 'edit']);
Route::get('/delete/{id}', [DosenController::class, 'delete']);

//---------------------------------Inventory----------------------------------//
Route::get('/inventory/alat', [AlatController::class, 'index']);
Route::get('/inventory/alat/createlemari', [AlatController::class, 'createlemari']);
Route::post('/inventory/alat/createlemari', [AlatController::class, 'storelemari']);
Route::post('/inventory/alat/createlokasi', [AlatController::class, 'storelokasi']);

Route::get('/alat', [AlatsController::class, 'index']);
Route::get('/alat/createalatc2a', [AlatsController::class, 'createalatc2a']);
Route::post('/alat/createalatc2a', [AlatsController::class, 'storealatc2a']);
//Route::post('/inventory/alat/createalatc2a', [AlatController::class, 'storealatc2a']);
Route::get('/alatc2a/{id_alat}', [AlatController::class, 'showc2a']);
Route::post('/editc2a/{id_alat}', [AlatController::class, 'editalatc2a']);
Route::get('/deletec2a/{id_alat}', [AlatController::class, 'deletec2a']);


Route::get('/alat/createalatc2b', [AlatsController::class, 'createalatc2b']);
Route::post('/alat/createalatc2b', [AlatsController::class, 'storealatc2b']);
//Route::post('/inventory/alat/createalatc2b', [AlatController::class, 'storealatc2b']);
Route::get('/alatc2b/{id_alat}', [AlatController::class, 'showc2b']);
Route::post('/editc2b/{id_alat}', [AlatController::class, 'editalatc2b']);
Route::get('/deletec2b/{id_alat}', [AlatController::class, 'deletec2b']);

Route::get('/inventory/bahan', [BahanController::class, 'index']);
Route::get('/bahan/create', [BahanController::class, 'create']);
Route::post('/bahan/create', [BahanController::class, 'store']);

Route::get('/inventory/barang', [BarangController::class, 'index']);
Route::get('/inventory/barang/create', [BarangController::class, 'create']);
Route::post('/inventory/barang/create', [BarangController::class, 'store']);
Route::get('/barang/{id_alat}', [BarangController::class, 'showbarang']);
Route::post('/editbarang/{id_alat}', [BarangController::class, 'editbarang']);
Route::get('/deletebarang/{id_alat}', [BarangController::class, 'deletebarang']);

//---------------------------------Praktikan----------------------------------//
Route::get('/praktikan/peserta', [PesertaController::class,'index']);

Route::get('/praktikan/kelompok', [PesertaController::class, 'indexkelompok']);
Route::get('/praktikan/createkelompok', [PesertaController::class, 'createkelompok']);
Route::post('/praktikan/createkelompok', [PesertaController::class, 'storekelompok']);


Route::get('/praktikan/absen', [AbsenController::class, 'index']);
Route::get('/praktikan/tugas', [TugasController::class, 'index']);
Route::post('/praktikan/createtugas', [TugasController::class, 'store']);

//---------------------------------Praktikum----------------------------------//
Route::get('/periode', [PeriodeController::class, 'index']);
Route::get('/periode/create', [PeriodeController::class, 'createperiode']);
Route::post('/periode/create', [PeriodeController::class, 'storeperiode']);
Route::get('/editperiode/{id_periode}', [PeriodeController::class, 'showperiode']);
Route::post('/editperiode/{id_periode}', [PeriodeController::class, 'editperiode']);
Route::get('/deleteperiode/{id_periode}', [PeriodeController::class, 'deleteperiode']);

Route::get('/kelas', [PraktikumController::class, 'index']);
Route::get('/praktikum/createkelas', [PraktikumController::class, 'createkelas']);
Route::post('/praktikum/createkelas', [PraktikumController::class, 'storekelas']);
Route::get('/praktikum/editekelas/{id_praktikum}', [PraktikumController::class, 'showkelas']);
Route::post('/praktikum/editekelas/{id_praktikum}', [PraktikumController::class, 'editkelas']);
Route::get('/praktikum/deletekelas/{id_praktikum}', [PraktikumController::class, 'deletekelas']);

Route::get('/modul', [ModulController::class, 'index']);
Route::get('/modul/createmodul', [ModulController::class, 'create']);
Route::post('/modul/createmodul', [ModulController::class, 'storemodul']);

Route::get('/modul/addItem/{id_modul}', [ModulController::class, 'addItem']);
Route::post('/modul/addItem', [ModulController::class, 'storeItem']);


//----------------------------------------Mahasiswa-----------------------------//
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);



