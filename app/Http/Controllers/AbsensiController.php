<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with(['jabatan', 'kehadiranNow'])->get();

        return view('pemilik.absensi', compact('pegawai'));
    }

    public function laporanGaji()
    {
        // Mengambil data pegawai beserta jabatan dan kehadirannya
        $pegawai = Pegawai::with(['jabatan', 'kehadiranNow'])->get();
        $totalGaji = 0;

        foreach ($pegawai as $p) {
            if ($p->kehadiranNow !== null) {
                $p->calculateJob();
                $totalGaji += $p->total_salary;
                $p->total_salary = 'Rp ' . number_format($p->total_salary, 0, '.', '.');
            }

            $p->gajiPerJam = number_format($p->jabatan->gajiperjam, 0, '.', '.');
        };

        // Kirim data ke view
        return view('pemilik.laporan_gaji', compact('pegawai', 'totalGaji'));
    }

    public function bayar(Request $request)
    {
        Kehadiran::where('id_kehadiran', $request->idKehadiran)->update(['statusgaji' => 1]);

        return redirect()->route('laporan_gaji');
    }


    public function laporanKehadiran()
    {
        // Mengambil data pegawai beserta jabatan dan kehadirannya
        $pegawai = Pegawai::with(['jabatan', 'kehadiran'])->get();

        // Kirim data ke view
        return view('pemilik.laporan_kehadiran', compact('pegawai'));
    }
}
