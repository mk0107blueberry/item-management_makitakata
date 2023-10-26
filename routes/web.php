<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ホーム画面　詳細ピン留めON/OFF
Route::post('/', [App\Http\Controllers\HomeController::class, 'pinIndex'])->name('home.pin');

// 一覧、登録
Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);

    // 詳細ピン留めON/OFF
    Route::post('/', [App\Http\Controllers\ItemController::class, 'pinIndex'])->name('index.pin');
});

// 詳細、編集、削除
Route::prefix('detail')->group(function () {
    Route::get('/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');
    
    // 詳細ピン留めON/OFF
    Route::post('/{id}', [App\Http\Controllers\ItemController::class, 'pin'])->name('detail.pin');
    
    Route::get('/{id}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('detail.edit');
    Route::patch('/{id}/edit', [App\Http\Controllers\ItemController::class, 'update'])->name('detail.update');
    Route::delete('/{id}/edit', [App\Http\Controllers\ItemController::class, 'destroy'])->name('detail.destroy');
});