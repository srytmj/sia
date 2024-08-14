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

use App\Http\Controllers\MasterDataController;
Route::get('/masterdata/{table}', [MasterDataController::class, 'index'])->middleware(['auth', 'verified']);
Route::post('/masterdata/store', [MasterDataController::class, 'store']);
Route::post('/masterdata/update', [MasterDataController::class, 'update']);
Route::post('/masterdata/delete', [MasterDataController::class, 'delete']);
Route::get('/table-columns/{table}/{id}', [MasterDataController::class, 'getTableColumns']);
Route::get('/masterdata/{table}/show/', [MasterDataController::class, 'show']);

require __DIR__.'/auth.php';
