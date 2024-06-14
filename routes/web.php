<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;


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
    return view('welcome');
});
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index'); // Via Pegawai
Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create'); // Creare Pegawai
Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store'); // Storare Pegawai
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit'); // Editare Pegawai
Route::put('/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update'); // Updateare Pegawai
Route::delete('/pegawai/{id}/destroy', [PegawaiController::class, 'destroy'])->name('pegawai.destroy'); // Delere Pegawai

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login'); // Ingressio
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']); // Autenticare
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout'); // Exitus

