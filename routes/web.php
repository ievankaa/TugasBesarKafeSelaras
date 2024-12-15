<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PegawaiController;
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

use Illuminate\Support\Facades\DB;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $message = "Koneksi ke database berhasil!";
    } catch (\Exception $e) {
        $message = "Koneksi gagal: " . $e->getMessage();
    }

    return view('test-db', compact('message'));
});

Route::middleware('cguest')->group(function () {
    Route::view('/', 'login')->name('login');
    Route::post('/login', [Controller::class, 'login'])->name('auth.login');
});

Route::get('/logout', [Controller::class, 'logout'])->name('auth.logout');

Route::middleware('cauth:admin')->group(function () {
    Route::get('/pemilik/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::get('/pemilik/laporan_gaji', [AbsensiController::class, 'laporanGaji'])->name('laporan_gaji');
    Route::post('/pemilik/laporan_gaji', [AbsensiController::class, 'bayar'])->name('bayar_gaji');
    Route::get('/pemilik/laporan_kehadiran', [AbsensiController::class, 'laporanKehadiran'])->name('pemilik.laporan_kehadiran');
    Route::get('/pemilik/tambah_data', [Controller::class, 'tambah_data'])->name('pemilik.tambah_data');
    Route::post('/pemilik/tambah_data', [Controller::class, 'send_data'])->name('pemilik.send_data');
    Route::get('/pemilik/data_pegawai', [Controller::class, 'datapegawai'])->name('pemilik.datapegawai');
    Route::get('/pemilik/data_pegawai_2', [Controller::class, 'datapegawai_2'])->name('pemilik.datapegawai_2');
    Route::get('/pemilik/data_pegawai_3', [Controller::class, 'datapegawai_3'])->name('pemilik.datapegawai_3');
    Route::get('/pemilik/edit_profil/{nohp?}', [Controller::class, 'edit_profil'])->name('pemilik.edit_profil');
    Route::put('/pemilik/edit_profil/{nohp}', [Controller::class, 'update_profil'])->name('pemilik.update_profil');
    Route::get('/pemilik/kelola_jabatan', [Controller::class, 'kelola_jabatan'])->name('pemilik.kelola_jabatan');
    Route::post('/pemilik/kelola_jabatan', [Controller::class, 'save_jabatan'])->name('pemilik.save_jabatan');
    Route::get('/pemilik/detail_laporan_kehadiran/{nohp?}', [Controller::class, 'detail_laporan_kehadiran'])->name('pemilik.detail_laporan_kehadiran');
});

Route::middleware('cauth:pegawai')->group(function () {
    Route::get('/pegawai/absensi_pegawai', [PegawaiController::class, 'index'])->name('pegawai.absensi');
    Route::post('/pegawai/absensi_pegawai', [PegawaiController::class, 'send_absensi'])->name('pegawai.send_absensi');
    Route::get('/pegawai/laporan_gaji_pegawai', [PegawaiController::class, 'laporan_gaji_pegawai'])->name('pegawai.laporan_gaji_pegawai');
    Route::get('/pegawai/laporanKehadiran_pegawai', [PegawaiController::class, 'laporanKehadiran_pegawai'])->name('pegawai.laporanKehadiran_pegawai');
});
