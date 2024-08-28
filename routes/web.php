<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Test;
Route::get('/test/{akun}', [test::class, 'test']);

// Masterdata
use App\Http\Controllers\Masterdata\PerusahaanController;
use App\Http\Controllers\Masterdata\UsersController;
use App\Http\Controllers\Masterdata\RolesController;
use App\Http\Controllers\Masterdata\CoaController;
use App\Http\Controllers\Masterdata\JabatanController;
use App\Http\Controllers\Masterdata\KaryawanController;
use App\Http\Controllers\Masterdata\PelangganController;
use App\Http\Controllers\Masterdata\SupplierController;
use App\Http\Controllers\Masterdata\BarangController;
use App\Http\Controllers\Masterdata\JasaController;

Route::prefix('masterdata')->group(function () {
    Route::resource('perusahaan', PerusahaanController::class);
    Route::resource('users', UsersController::class);
    Route::resource('user_role', RolesController::class);
    Route::resource('coa', CoaController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('jasa', JasaController::class);
    Route::post('/jasa/storedetail/', [JasaController::class, 'storedetail']);
    Route::get('/jasa/editdetail/{id}', [JasaController::class, 'editdetail']);
    Route::put('/jasa/updatedetail/{id}', [JasaController::class, 'updatedetail']);
    Route::delete('/jasa/destroydetail/{id}', [JasaController::class, 'destroydetail'])->name('jasa.destroydetail');
});

// Transaksi
use App\Http\Controllers\Transaksi\PembelianController;
use App\Http\Controllers\Transaksi\PembeliandetailController;
use App\Http\Controllers\Transaksi\PenjualanController;
use App\Http\Controllers\Transaksi\PenggajianController;
use App\Http\Controllers\Transaksi\PelunasanController;
Route::prefix('transaksi')->group(function () {
    Route::resource('/pembelian', PembelianController::class);
    Route::resource('/pembeliandetail', PembeliandetailController::class);
    Route::get('/pembelian-detail/{id_pembelian}', [PembelianDetailController::class, 'index'])->name('pembeliandetail.index');
    Route::post('/pembeliandetail/store', [PembelianDetailController::class, 'store'])->name('pembeliandetail.store');
    Route::post('/pembeliandetail/save', [PembelianDetailController::class, 'save'])->name('pembeliandetail.save');
    Route::post('/pembelian-detail/{id_pembelian}/pelunasan', [PembelianDetailController::class, 'pelunasan'])->name('pembeliandetail.pelunasan');

    // Route::resource('penjualan', PenjualanController::class);
    // Route::resource('penggajian', PenggajianController::class);
    // Route::resource('pelunasan', PelunasanController::class);
});





// use App\Http\Controllers\MasterDataController;
// Route::get('/masterdata/{table}', [MasterDataController::class, 'index'])->middleware(['auth', 'verified']);
// Route::post('/masterdata/store', [MasterDataController::class, 'store']);
// Route::post('/masterdata/update', [MasterDataController::class, 'update']);
// Route::post('/masterdata/delete', [MasterDataController::class, 'delete']);
// Route::get('/table-columns/{table}/{id}', [MasterDataController::class, 'getTableColumns']);
// Route::get('/masterdata/{table}/show/', [MasterDataController::class, 'show']);

require __DIR__.'/auth.php';
