<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\WorkunitController;
use App\Http\Controllers\PetugasController;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::group(['middleware' => 'auth'], function () {

    // =============
    // Admin Master
    // =============
    Route::group(['middleware' => ['role:admin-master','status:aktif'], 'prefix' => 'admin-master', 'as' => 'admin-master.'], function () {

        Route::get('dashboard', [MasterController::class, 'index']);
        Route::get('show-warehouse', [MasterController::class, 'showWarehouse']);
        Route::get('show-workunit', [MasterController::class, 'showWorkunit']);
        Route::get('detail-warehouse/{id}', [MasterController::class, 'detailWarehouse']);
        Route::get('detail-slot/{id}', [MasterController::class, 'detailSlot']);

        Route::post('update-warehouse/{id}', [MasterController::class, 'updateWarehouse']);
    });

    // =============
    // Petugas Gudang
    // =============
    Route::group(['middleware' => ['role:petugas','status:aktif'], 'prefix' => 'petugas', 'as' => 'petugas.'],
        function () {

        Route::get('dashboard', [PetugasController::class, 'index']);
        Route::get('gudang/{aksi}/{id}', [PetugasController::class, 'showWarehouse']);
        Route::get('aktivitas/{aksi}/{id}', [PetugasController::class, 'showActivity']);
        Route::get('barang/{aksi}/{id}', [PetugasController::class, 'showItem']);

        Route::post('barang/{aksi}/{id}', [PetugasController::class, 'showItem']);

        Route::get('daftar-aktivitas/{id}', [PetugasController::class, 'showActivity']);
        Route::get('daftar-pengeluaran', [PetugasController::class, 'showIssued']);
        Route::get('pengiriman-barang', [PetugasController::class, 'creteDeliverySingle']);
        Route::get('pengeluaran-barang', [PetugasController::class, 'createPickupSingle']);
        Route::get('buat-bast/{id}', [PetugasController::class, 'createBAST']);
        Route::get('cetak-bast/{id}', [PetugasController::class, 'printBAST']);

        Route::post('tambah-kelengkapan-barang/{id}', [PetugasController::class, 'postCompleteItem']);
        Route::post('tambah-barang', [PetugasController::class, 'postDeliverySingle']);
        Route::post('ambil-barang', [PetugasController::class, 'postPickupSingle']);

        Route::post('select2-workunit', [PetugasController::class, 'select2Workunit']);
        Route::post('select2-item', [PetugasController::class, 'select2Item']);
        Route::get('json-get-mainunit', [PetugasController::class, 'jsonGetMainunit']);
        Route::get('json-get-slot', [PetugasController::class, 'jsonGetSlot']);
        Route::get('json-get-warehouse', [PetugasController::class, 'jsonGetWarehouse']);
        Route::get('json-get-detail-item', [PetugasController::class, 'jsonGetDetailItem']);
    });

    // =============
    // Unit Kerja
    // =============
    Route::group(['middleware' => ['role:unit-kerja','status:aktif'], 'prefix' => 'unit-kerja', 'as' => 'unit-kerja.'],
        function () {

        Route::get('dashboard', [WorkunitController::class, 'index']);
        Route::get('surat/{aksi}/{id}', [WorkunitController::class, 'showAppLetter']);


        Route::post('surat/{aksi}/{id}', [WorkunitController::class, 'showAppLetter']);

        Route::get('menu-barang', [WorkunitController::class, 'showItem']);
        Route::get('menu-gudang', [WorkunitController::class, 'showWarehouse']);
        Route::get('menu-panduan', [WorkunitController::class, 'showGuide']);
        Route::get('menu-surat-perintah', [WorkunitController::class, 'showWarrent']);
        Route::get('detail-gudang/{id}', [WorkunitController::class, 'detailWarehouse']);
        Route::get('detail-slot/{id}', [WorkunitController::class, 'detailSlot']);
    });

});
