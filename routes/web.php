<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\WorkunitController;
use App\Http\Controllers\WorkteamController;

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
    return redirect('main/dashboard');
});

Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
    Route::get('dashboard', function() { return view('v_main.index'); });
    Route::get('prosedur', function() { return view('v_main.prosedur'); });
    Route::get('gudang/{aksi}', [MainController::class, 'warehouse']);
});



Route::group(['middleware' => 'auth'], function () {
    // =============
    // Admin Master
    // =============
    Route::group(['middleware' => ['role:admin-master','status:aktif'], 'prefix' => 'admin-master', 'as' => 'admin-master.'], function () {

        Route::get('dashboard', [MasterController::class, 'index']);
        Route::get('show-warehouse', [MasterController::class, 'showWarehouse']);
        Route::get('detail-warehouse/{id}', [MasterController::class, 'detailWarehouse']);
        Route::get('detail-slot/{id}', [MasterController::class, 'detailSlot']);
        Route::get('barang/{aksi}/{id}', [MasterController::class, 'showItem']);
        Route::get('gudang/{aksi}/{id}', [MasterController::class, 'showWarehouse']);
        Route::get('unit-kerja/{aksi}/{id}', [MasterController::class, 'showWorkunit']);
        Route::get('pengguna/{aksi}/{id}', [MasterController::class, 'showUser']);
        Route::get('grafic', [MasterController::class, 'searchChartData']);
        Route::get('json/{aksi}/{id}', [MasterController::class, 'showJson']);

        Route::post('pengguna/{aksi}/{id}', [MasterController::class, 'showUser']);
        Route::post('gudang/{aksi}/{id}', [MasterController::class, 'showWarehouse']);
        Route::post('unit-kerja/{aksi}/{id}', [MasterController::class, 'showWorkunit']);
        Route::post('barang/{aksi}/{id}', [MasterController::class, 'showItem']);
        Route::post('update-warehouse/{id}', [MasterController::class, 'updateWarehouse']);
        Route::post('select2/{aksi}/{id}', [MasterController::class, 'showSelect2']);
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
        Route::get('surat-perintah/{aksi}/{id}', [PetugasController::class, 'showWarrent']);

        Route::post('surat-perintah/{aksi}/{id}', [PetugasController::class, 'showWarrent']);
        Route::post('barang/{aksi}/{id}', [PetugasController::class, 'showItem']);

        Route::get('daftar-aktivitas/{id}', [PetugasController::class, 'showActivity']);
        Route::get('daftar-pengeluaran', [PetugasController::class, 'showIssued']);
        Route::get('pengiriman-barang', [PetugasController::class, 'creteDeliverySingle']);
        Route::get('pengeluaran-barang', [PetugasController::class, 'createPickupSingle']);
        Route::get('buat-bast/{id}', [PetugasController::class, 'createBAST']);
        Route::get('cetak-bast/{id}', [PetugasController::class, 'printBAST']);
        Route::get('print-qrcode/{id}', [PetugasController::class, 'printQRCode']);
        Route::get('get-item/{id}', [PetugasController::class, 'getItem']);
        Route::get('get-warehouse/{id}', [PetugasController::class, 'getWarehouse']);

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
        Route::get('surat/{aksi}/{id}', [WorkunitController::class, 'showLetter']);
        Route::get('surat-perintah/{aksi}/{id}', [WorkunitController::class, 'showWarrent']);
        Route::get('json/{aksi}', [WorkunitController::class, 'showJson']);
        Route::get('get-item/{id}', [WorkunitController::class, 'getItem']);

        Route::post('surat-perintah/{aksi}/{id}', [WorkunitController::class, 'showWarrent']);
        Route::post('surat/{aksi}/{id}', [WorkunitController::class, 'showLetter']);

        Route::get('menu-barang/{aksi}/{id}', [WorkunitController::class, 'showItem']);
        Route::get('menu-gudang', [WorkunitController::class, 'showWarehouse']);
        Route::get('menu-panduan', [WorkunitController::class, 'showGuide']);
        Route::get('menu-surat-perintah', [WorkunitController::class, 'showWarrent']);
        Route::get('detail-gudang/{id}', [WorkunitController::class, 'detailWarehouse']);
        Route::get('detail-slot/{id}', [WorkunitController::class, 'detailSlot']);
    });

    // =============
    // TIM KERJA
    // =============
    Route::group(['middleware' => ['role:tim-kerja','status:aktif'], 'prefix' => 'tim-kerja', 'as' => 'tim-kerja.'],
        function () {

        Route::get('dashboard', [WorkteamController::class, 'index']);
        Route::get('surat/{aksi}/{id}', [WorkteamController::class, 'showLetter']);
        Route::get('barang/{aksi}/{id}', [WorkteamController::class, 'showItem']);

    });

});
