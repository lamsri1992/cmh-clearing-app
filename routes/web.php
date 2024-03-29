<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\paid;
use App\Http\Controllers\charge;
use App\Http\Controllers\process;
use App\Http\Controllers\importController;
use App\Http\Controllers\cmh;

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
    return view('auth.login');
});

// Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('/')->group(function () {
    Route::get('dashboard', [dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('paid', [paid::class, 'index'])->name('paid');
    Route::get('charge', [charge::class, 'index'])->name('charge');
    Route::get('process', [process::class, 'index'])->name('process');
    Route::get('deny', [dashboard::class, 'deny'])->name('deny');
});

Route::prefix('charge')->group(function () {
    // Route::get('/confirm', [charge::class, 'confirm'])->name('charge.confirm');
    Route::get('/cancel', [charge::class, 'cancel'])->name('charge.cancel');
    Route::get('/list', [charge::class, 'list'])->name('charge.list');
    Route::post('/import', [importController::class, 'import'])->name('charge.import');
    Route::get('/sent', [charge::class, 'sent'])->name('charge.sent');
    Route::get('/sent/{id}', [charge::class, 'detail'])->name('charge.detail');
    Route::post('/bill', [charge::class, 'bill'])->name('charge.bill');
    Route::get('/list/{id}', [charge::class, 'transaction'])->name('charge.transaction');
    Route::get('/{id}', [charge::class, 'show'])->name('charge.show');
});

Route::prefix('paid')->group(function () {
    Route::get('/', [paid::class, 'index'])->name('paid.index');
    Route::get('/confirm', [paid::class, 'confirm'])->name('paid.confirm');
    Route::get('/deny', [paid::class, 'deny'])->name('paid.deny');
    Route::get('/list', [paid::class, 'list'])->name('paid.list');
    Route::get('/success', [paid::class, 'success'])->name('paid.success');
    Route::get('{id}', [paid::class, 'show'])->name('ระบบการตามจ่าย');
    Route::get('/transaction/{id}', [paid::class, 'detail'])->name('paid.detail');
    Route::get('/transaction/confirm/{id}', [paid::class, 'transConfirm'])->name('paid.transConfirm');
    Route::post('file-upload', [paid::class, 'upload'])->name('paid.upload');
});

Route::prefix('process')->group(function () {
    Route::get('/benefit/map', [process::class, 'mapping'])->name('process.map');
});

Route::prefix('cmh')->group(function () {
    Route::get('/', [cmh::class, 'index'])->name('cmh.index');
});

require __DIR__.'/auth.php';
