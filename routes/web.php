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

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Pemilik Routes
Route::prefix('pemilik')->group(function () {
    Route::get('/kafe-selaras', function () {
        return view('pemilik.kafe_selaras');
    });

    Route::get('/absensi', function () {
        return view('pemilik.absensi');
    });

    /*Route::get('/data_pegawai_2', function () {
        return view('pemilik.data_pegawai_2');
    });

    Route::get('/data_pegawai_3', function () {
        return view('pemilik.data_pegawai_3');
    });*/

    Route::get('/data_pegawai', function () {
        return view('pemilik.data_pegawai');
    });

    Route::get('/detail_laporan_kehadiran', function () {
        return view('pemilik.detail_laporan_kehadiran');
    });

    Route::get('/edit_profil', function () {
        return view('pemilik.edit_profil');
    });

    Route::get('/kelola_jabatan', function () {
        return view('pemilik.kelola_jabatan');
    });

    Route::get('/laporan_gaji', function () {
        return view('pemilik.laporan_gaji');
    });

    Route::get('/laporan_kehadiran', function () {
        return view('pemilik.laporan_kehadiran');
    });

    Route::get('/tambah_data', function () {
        return view('pemilik.tambah_data');
    });
});

// Pegawai Routes
Route::prefix('pegawai')->group(function () {
    Route::get('/absensi_pegawai', function () {
        return view('pegawai.absensi_pegawai');
    });

    Route::get('/kafe_selaras_pegawai', function () {
        return view('pegawai.kafe_selaras_pegawai');
    });

    Route::get('/laporanGaji_pegawai', function () {
        return view('pegawai.laporanGaji_pegawai');
    });

    Route::get('/laporanKehadiran_pegawai', function () {
        return view('pegawai.laporanKehadiran_pegawai');
    });
});