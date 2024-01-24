<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\paid;
use App\Http\Controllers\charge;
use App\Http\Controllers\process;

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
});

Route::prefix('charge')->group(function () {
    Route::get('/filter', [charge::class, 'filter'])->name('charge.filter');
    Route::get('/confirm', [charge::class, 'confirm'])->name('charge.confirm');
    Route::get('/list', [charge::class, 'list'])->name('charge.list');
    Route::get('/sent', [charge::class, 'sent'])->name('charge.sent');
    Route::get('/sent/{id}', [charge::class, 'detail'])->name('charge.detail');
    Route::post('/bill', [charge::class, 'bill'])->name('charge.bill');
    Route::get('/list/{id}', [charge::class, 'transaction'])->name('charge.transaction');
    Route::get('/{id}', [charge::class, 'show'])->name('charge.show');
});

Route::prefix('paid')->group(function () {
    Route::get('/', [paid::class, 'index'])->name('paid.index');
    Route::get('/confirm', [paid::class, 'confirm'])->name('paid.confirm');
    Route::get('/list', [paid::class, 'list'])->name('paid.list');
    Route::get('{id}', [paid::class, 'show'])->name('ระบบการตามจ่าย');
    Route::get('/transaction/{id}', [paid::class, 'detail'])->name('paid.detail');
    Route::get('/transaction/confirm/{id}', [paid::class, 'transConfirm'])->name('paid.transConfirm');
    Route::post('file-upload', [paid::class, 'upload'])->name('paid.upload');
});

require __DIR__.'/auth.php';
