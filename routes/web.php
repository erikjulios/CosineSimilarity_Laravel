<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChartController;

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
    return view('auth/login');
});
Route::get('index', function () {
    return view('index');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
// Route::get('/textMining/{judul}/{abstrak}', [App\Http\Controllers\textMiningController::class, 'execute'])->name('textMining');
Route::post('/textMining', [App\Http\Controllers\textMiningController::class, 'execute'])->name('textMining');
Route::get('/detail/{id}', [App\Http\Controllers\textMiningController::class, 'showDetail'])->name('detail');

// datatable
Route::get('history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
Route::get('data/datatables', [App\Http\Controllers\HomeController::class, 'datatables'])->name('data.datatables');
Route::get('detail_persentases_judul/{id}', [App\Http\Controllers\textMiningController::class, 'detail_persentase_judul'])->name('detail_persentases_judul');
Route::get('detail_persentases_abstrak/{id}', [App\Http\Controllers\textMiningController::class, 'detail_persentase_abstrak'])->name('detail_persentases_abstrak');

// login admin
Route::get('/loginAdmin', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('loginAdmin');
Route::get('/homeAdmin', [App\Http\Controllers\AdminController::class, 'home'])->name('homeAdmin');
Route::post('/loginAdmin', [App\Http\Controllers\AdminController::class, 'login'])->name('loginAdmin');
Route::post('/logoutAdmin', [App\Http\Controllers\AdminController::class, 'logout'])->name('logoutAdmin');

Route::get('history-check', [App\Http\Controllers\AdminController::class, 'history'])->name('history-check');
Route::get('data/datatables-admin', [App\Http\Controllers\AdminController::class, 'datatables'])->name('data.datatables-admin');

// action admin
Route::get('delete/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->name('delete');
Route::get('approve/{id}', [App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
Route::get('reject/{id}', [App\Http\Controllers\AdminController::class, 'reject'])->name('reject');

// chart
Route::get('/aaa', [App\Http\Controllers\AdminController::class, 'p_judul']);
Route::get('tester', [App\Http\Controllers\textMiningController::class, 'calculateTFIDF'])->name('tester');

//API
Route::get('api', [App\Http\Controllers\textMiningController::class, 'getAPI'])->name('api');
