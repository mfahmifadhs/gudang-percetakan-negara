<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Barang;
use App\Http\Controllers\BeritaAcara;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Gedung;
use App\Http\Controllers\KategoriGedung;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ModelPenyimpanan;
use App\Http\Controllers\Pegawai;
use App\Http\Controllers\Pengajuan;
use App\Http\Controllers\Penyimpanan;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UnitKerja;
use App\Http\Controllers\UnitUtama;
use App\Http\Controllers\WorkunitController;
use App\Http\Controllers\WorkteamController;
use App\Http\Controllers\User;

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

Route::get('detail/barang/{id}', [Barang::class, 'Scan']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [Dashboard::class, 'Show'])->name('dashboard');


    Route::group(['middleware' => ['access:public']], function () {

        // Gedung Percetakan Negara
        Route::get('gedung/daftar', [Gedung::class, 'Show'])->name('warehouse.show');
        Route::get('gedung/detail/{id}', [Gedung::class, 'Detail'])->name('warehouse.detail');
        // Kategori Gedung
        Route::get('kategori-gedung/daftar', [KategoriGedung::class, 'Show'])->name('warehouseCategory.show');
        // Model Penyimpanan
        Route::get('model-penyimpanan/daftar', [ModelPenyimpanan::class, 'Show'])->name('storageModel.show');
        // Penyimpanan
        Route::get('gedung/penyimpanan/daftar', [Penyimpanan::class, 'Show'])->name('storage.show');
        Route::get('gedung/penyimpanan/detail/{id}', [Penyimpanan::class, 'Detail'])->name('storage.detail');

    });

    Route::group(['middleware' => ['access:private']], function () {

        // Gedung Percetakan Negara
        Route::get('gedung/tambah', [Gedung::class, 'Create'])->name('warehouse.create');
        Route::get('gedung/{id}', [Gedung::class, 'Edit'])->name('warehouse.edit');
        Route::post('gedung/tambah', [Gedung::class, 'Store'])->name('warehouse.post');
        Route::post('gedung/{id}', [Gedung::class, 'Update'])->name('warehouse.update');
        Route::get('gedung/hapus/{id}', [Gedung::class, 'Delete'])->name('warehouse.delete');
        // Kategori Gedung
        Route::get('kategori-gedung/tambah', [KategoriGedung::class, 'Create'])->name('warehouseCategory.create');
        Route::get('kategori-gedung/{id}', [KategoriGedung::class, 'Edit'])->name('warehouseCategory.edit');
        Route::post('kategori-gedung/tambah', [KategoriGedung::class, 'Store'])->name('warehouseCategory.post');
        Route::post('kategori-gedung/{id}', [KategoriGedung::class, 'Update'])->name('warehouseCategory.update');
        Route::get('kategori-gedung/hapus/{id}', [KategoriGedung::class, 'Delete'])->name('warehouseCategory.delete');
        // Model Penyimpanan
        Route::get('model-penyimpanan/tambah', [ModelPenyimpanan::class, 'Create'])->name('storageModel.create');
        Route::get('model-penyimpanan/{id}', [ModelPenyimpanan::class, 'Edit'])->name('storageModel.edit');
        Route::post('model-penyimpanan/tambah', [ModelPenyimpanan::class, 'Store'])->name('storageModel.post');
        Route::post('model-penyimpanan/{id}', [ModelPenyimpanan::class, 'Update'])->name('storageModel.update');
        Route::get('model-penyimpanan/hapus/{id}', [ModelPenyimpanan::class, 'Delete'])->name('storageModel.delete');
        // Penyimpanan
        Route::get('gedung/penyimpanan/tambah', [Penyimpanan::class, 'Create'])->name('storage.create');
        Route::get('gedung/penyimpanan/{id}', [Penyimpanan::class, 'Edit'])->name('storage.edit');
        Route::post('gedung/penyimpanan/tambah', [Penyimpanan::class, 'Store'])->name('storage.post');
        Route::post('gedung/penyimpanan/{id}', [Penyimpanan::class, 'Update'])->name('storage.update');
        Route::get('gedung/penyimpanan/hapus/{id}', [Penyimpanan::class, 'Delete'])->name('storage.delete');
        // User
        Route::get('user/daftar', [User::class, 'Show'])->name('user.show');
        Route::get('user/tambah', [User::class, 'Create'])->name('user.create');
        Route::get('user/{id}', [User::class, 'Edit'])->name('user.edit');
        Route::post('user/tambah', [User::class, 'Store'])->name('user.post');
        Route::post('user/{id}', [User::class, 'Update'])->name('user.update');
        Route::get('user/hapus/{id}', [User::class, 'Delete'])->name('user.delete');
        // Pegawai
        Route::get('pegawai/daftar', [Pegawai::class, 'Show'])->name('employee.show');
        Route::get('pegawai/tambah', [Pegawai::class, 'Create'])->name('employee.create');
        Route::get('pegawai/{id}', [Pegawai::class, 'Edit'])->name('employee.edit');
        Route::post('pegawai/tambah', [Pegawai::class, 'Store'])->name('employee.post');
        Route::post('pegawai/{id}', [Pegawai::class, 'Update'])->name('employee.update');
        Route::get('pegawai/hapus/{id}', [Pegawai::class, 'Delete'])->name('employee.delete');
        // Unit Kerja
        Route::get('unit-kerja/daftar', [UnitKerja::class, 'Show'])->name('workunit.show');
        Route::get('unit-kerja/tambah', [UnitKerja::class, 'Create'])->name('workunit.create');
        Route::get('unit-kerja/{id}', [UnitKerja::class, 'Edit'])->name('workunit.edit');
        Route::post('unit-kerja/tambah', [UnitKerja::class, 'Store'])->name('workunit.post');
        Route::post('unit-kerja/{id}', [UnitKerja::class, 'Update'])->name('workunit.update');
        Route::get('unit-kerja/hapus/{id}', [UnitKerja::class, 'Delete'])->name('workunit.delete');
        // Unit Utama
        Route::get('unit-utama/daftar', [UnitUtama::class, 'Show'])->name('mainunit.show');
        Route::get('unit-utama/tambah', [UnitUtama::class, 'Create'])->name('mainunit.create');
        Route::get('unit-utama/{id}', [UnitUtama::class, 'Edit'])->name('mainunit.edit');
        Route::post('unit-utama/tambah', [UnitUtama::class, 'Store'])->name('mainunit.post');
        Route::post('unit-utama/{id}', [UnitUtama::class, 'Update'])->name('mainunit.update');
        Route::get('unit-utama/hapus/{id}', [UnitUtama::class, 'Delete'])->name('mainunit.delete');

    });

    Route::group(['middleware' => ['access:verify']], function () {

        Route::get('pengajuan/verifikasi/{id}', [Pengajuan::class, 'Check'])->name('submission.check');
        Route::post('pengajuan/verifikasi/{id}', [Pengajuan::class, 'CheckStore'])->name('submission.filter');

    });

    Route::group(['middleware' => ['access:filter']], function () {

        Route::get('pengajuan/penapisan/{id}', [Pengajuan::class, 'Filter'])->name('submission.filter');
        Route::post('pengajuan/penapisan/{id}', [Pengajuan::class, 'FilterStore'])->name('submission.filter');

    });

    Route::group(['middleware' => ['access:process']], function () {

        Route::get('pengajuan/proses/{id}', [Pengajuan::class, 'Process'])->name('submission.process');
        Route::post('pengajuan/proses/{id}', [Pengajuan::class, 'ProcessStore'])->name('submission.process');

    });

    Route::group(['middleware' => ['access:user']], function () {

        Route::get('pengajuan/tambah/{id}', [Pengajuan::class, 'Create'])->name('submission.create');
        Route::post('pengajuan/tambah/page={id}', [Pengajuan::class, 'Create'])->name('submission.page');
        Route::post('pengajuan/tambah/{id}', [Pengajuan::class, 'Store'])->name('submission.post');

    });

    // Pengajuan
    Route::get('pengajuan/daftar', [Pengajuan::class, 'Show'])->name('submission.show');
    Route::get('pengajuan/{id}', [Pengajuan::class, 'Edit'])->name('submission.edit');
    Route::get('pengajuan/detail/{id}', [Pengajuan::class, 'Detail'])->name('submission.detail');
    Route::get('pengajuan/hapus/{id}', [Pengajuan::class, 'Delete'])->name('submission.delete');
    Route::post('pengajuan/preview/{id}', [Pengajuan::class, 'Preview'])->name('submission.preview');
    Route::post('pengajuan/update/{id}', [Pengajuan::class, 'Update'])->name('submission.update');

    Route::post('pengajuan/barcode/{id}', [Pengajuan::class, 'Barcode'])->name('submission.barcode');

    // Barang
    Route::get('barang/daftar', [Barang::class, 'Show'])->name('item.show');
    Route::get('barang/detail/{id}', [Barang::class, 'Detail'])->name('item.detail');
    Route::post('barang/barcode/{id}', [Barang::class, 'Barcode'])->name('item.barcode');

    // Berita Acara
    Route::get('surat/berita-acara/{id}', [BeritaAcara::class, 'Show'])->name('bast.show');
    Route::get('cetak/berita-acara/{id}', [BeritaAcara::class, 'Print'])->name('submission.print');
    Route::get('verif/berita-acara/{id}', [BeritaAcara::class, 'Barcode']);


    // Ajax
    Route::post('get-slots-warehouse', [Pengajuan::class, 'GetSlotByWarehouse'])->name('submission.getSlotByWarehouse');

    // Preview Surat
    Route::get('/surat/preview/{path}', function ($path) {
        $decryptedPath = Crypt::decrypt($path);
        $file = storage_path('app/' . $decryptedPath);
        return response()->download($file);
    });
});























Route::get('/barang/{id}', [Controller::class, 'item']);
// Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
    Route::get('dashboard', function () {
        return view('v_main.index');
    });
    Route::get('prosedur', function () {
        return view('v_main.prosedur');
    });
    Route::get('gudang/{aksi}', [MainController::class, 'warehouse']);
    Route::get('profil/{aksi}/{id}', [MainController::class, 'Profile']);

    Route::post('profil/{aksi}/{id}', [MainController::class, 'Profile']);
});



Route::group(['middleware' => 'auth'], function () {
    // =============
    // Admin Master
    // =============
    Route::group(['middleware' => ['role:admin-master', 'status:aktif'], 'prefix' => 'admin-master', 'as' => 'admin-master.'], function () {

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
    Route::group(
        ['middleware' => ['role:petugas', 'status:aktif'], 'prefix' => 'petugas', 'as' => 'petugas.'],
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
            Route::get('penyimpanan-barang', [PetugasController::class, 'creteDeliverySingle']);
            Route::get('pengeluaran-barang', [PetugasController::class, 'createPickupSingle']);
            Route::get('buat-bast/{id}', [PetugasController::class, 'createBAST']);
            Route::get('cetak-bast/{id}', [PetugasController::class, 'printBAST']);
            Route::get('print-qrcode/{id}', [PetugasController::class, 'printQRCode']);
            Route::get('get-item/{id}', [PetugasController::class, 'getItem']);
            Route::get('get-warehouse/{id}', [PetugasController::class, 'getWarehouse']);

            Route::post('tambah-kelengkapan-barang/{id}', [PetugasController::class, 'postCompleteItem']);
            Route::post('tambah-barang', [PetugasController::class, 'postDeliverySingle']);
            Route::post('ambil-barang', [PetugasController::class, 'postPickupSingle']);
            Route::post('aktivitas/{aksi}/{id}', [PetugasController::class, 'showActivity']);
            Route::post('print-qrcode/{id}', [PetugasController::class, 'printQRCode']);

            Route::post('select2/{id}', [PetugasController::class, 'select2']);
            Route::post('select2-workunit', [PetugasController::class, 'select2Workunit']);
            Route::post('select2-item', [PetugasController::class, 'select2Item']);
            Route::get('json-get-mainunit', [PetugasController::class, 'jsonGetMainunit']);
            Route::get('json-get-slot', [PetugasController::class, 'jsonGetSlot']);
            Route::get('json-get-warehouse', [PetugasController::class, 'jsonGetWarehouse']);
            Route::get('json-get-detail-item', [PetugasController::class, 'jsonGetDetailItem']);
        }
    );

    // =============
    // Unit Kerja
    // =============
    Route::group(
        ['middleware' => ['role:unit-kerja', 'status:aktif'], 'prefix' => 'unit-kerja', 'as' => 'unit-kerja.'],
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
        }
    );

    // =============
    // TIM KERJA
    // =============
    Route::group(
        ['middleware' => ['role:tim-kerja', 'status:aktif'], 'prefix' => 'tim-kerja', 'as' => 'tim-kerja.'],
        function () {

            Route::get('dashboard', [WorkteamController::class, 'index']);
            Route::get('surat/{aksi}/{id}', [WorkteamController::class, 'showLetter']);
            Route::get('barang/{aksi}/{id}', [WorkteamController::class, 'showItem']);
        }
    );
});
