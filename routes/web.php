<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\paid;
use App\Http\Controllers\charge;
use App\Http\Controllers\create;
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
    Route::get('paid', [paid::class, 'index'])->middleware(['auth', 'verified'])->name('paid');
    Route::get('charge', [charge::class, 'index'])->middleware(['auth', 'verified'])->name('charge');
    Route::get('process', [process::class, 'index'])->middleware(['auth', 'verified'])->name('process');
    Route::get('deny', [dashboard::class, 'deny'])->middleware(['auth', 'verified'])->name('deny');
});

Route::prefix('charge')->group(function () {
    // Route::get('/confirm', [charge::class, 'confirm'])->middleware(['auth', 'verified'])->name('charge.confirm');
    Route::get('/cancel', [charge::class, 'cancel'])->middleware(['auth', 'verified'])->name('charge.cancel');
    Route::get('/list', [charge::class, 'list'])->middleware(['auth', 'verified'])->name('charge.list');
    Route::post('/import', [importController::class, 'import'])->middleware(['auth', 'verified'])->name('charge.import');
    Route::get('/sent', [charge::class, 'sent'])->middleware(['auth', 'verified'])->name('charge.sent');
    Route::get('/sent/{id}', [charge::class, 'detail'])->middleware(['auth', 'verified'])->name('charge.detail');
    Route::post('/bill', [charge::class, 'bill'])->middleware(['auth', 'verified'])->name('charge.bill');
    Route::get('/list/{id}', [charge::class, 'transaction'])->middleware(['auth', 'verified'])->name('charge.transaction');
    Route::get('/create', [charge::class, 'create'])->middleware(['auth', 'verified'])->name('charge.create');
    Route::get('/{id}', [charge::class, 'show'])->middleware(['auth', 'verified'])->name('charge.show');
});

Route::prefix('create')->group(function () {
    Route::get('/', [create::class, 'index'])->middleware(['auth', 'verified'])->name('create.index');
    Route::post('/add', [create::class, 'add'])->middleware(['auth', 'verified'])->name('create.add');
});

Route::prefix('paid')->group(function () {
    Route::get('/', [paid::class, 'index'])->middleware(['auth', 'verified'])->name('paid.index');
    Route::get('/confirm', [paid::class, 'confirm'])->middleware(['auth', 'verified'])->name('paid.confirm');
    Route::get('/deny', [paid::class, 'deny'])->middleware(['auth', 'verified'])->name('paid.deny');
    Route::get('/list', [paid::class, 'list'])->middleware(['auth', 'verified'])->name('paid.list');
    Route::get('/success', [paid::class, 'success'])->middleware(['auth', 'verified'])->name('paid.success');
    Route::get('{id}', [paid::class, 'show'])->middleware(['auth', 'verified'])->name('ระบบการตามจ่าย');
    Route::get('/transaction/{id}', [paid::class, 'detail'])->middleware(['auth', 'verified'])->name('paid.detail');
    Route::get('/transaction/confirm/{id}', [paid::class, 'transConfirm'])->middleware(['auth', 'verified'])->name('paid.transConfirm');
    Route::post('file-upload', [paid::class, 'upload'])->middleware(['auth', 'verified'])->name('paid.upload');
});

Route::prefix('process')->group(function () {
    Route::get('/benefit/map', [process::class, 'mapping'])->middleware(['auth', 'verified'])->name('process.map');
});

Route::prefix('cmh')->group(function () {
    Route::get('/', [cmh::class, 'index'])->middleware(['auth', 'verified'])->name('cmh.index');
    Route::get('/report', [cmh::class, 'report'])->middleware(['auth', 'verified'])->name('cmh.report');
    Route::get('/transaction', [cmh::class, 'fetch'])->middleware(['auth', 'verified'])->name('cmh.transaction');
    Route::get('/transaction/{id}', [cmh::class, 'detail'])->middleware(['auth', 'verified'])->name('cmh.detail');
    Route::get('/process', [cmh::class, 'process'])->middleware(['auth', 'verified'])->name('cmh.process');
});

require __DIR__.'/auth.php';
