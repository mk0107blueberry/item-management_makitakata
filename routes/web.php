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
// ホーム画面 : 個別ピン留めON/OFF
Route::post('/', [App\Http\Controllers\HomeController::class, 'pinIndex'])->name('home.pin');
// ホーム画面 : 一括ピン留めON/OFF
Route::put('/', [App\Http\Controllers\HomeController::class, 'pinItems'])->name('home.pins');

// 一覧、登録
Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);

    // 詳細ピン留めON/OFF
    Route::post('/', [App\Http\Controllers\ItemController::class, 'pinIndex'])->name('index.pin');

    // カテゴリーごとの一覧
    Route::get('/category/{category_id}', [App\Http\Controllers\ItemController::class, 'category'])->name('category');
});

// 詳細、編集、削除
Route::prefix('detail')->group(function () {
    Route::get('/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');
    
    // 詳細ピン留めON/OFF
    Route::post('/{id}', [App\Http\Controllers\ItemController::class, 'pin'])->name('detail.pin');
    Route::patch('/{id}', [App\Http\Controllers\ItemController::class, 'memoUpdate'])->name('detail.memoUpdate');
    
    Route::get('/{id}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('detail.edit');
    Route::patch('/{id}/edit', [App\Http\Controllers\ItemController::class, 'update'])->name('detail.update');
    Route::delete('/{id}/edit', [App\Http\Controllers\ItemController::class, 'destroy'])->name('detail.destroy');
});