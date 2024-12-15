<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $nohp = session('nohp');
        $pegawai = Pegawai::where('nohp', $nohp)->with('jabatan')->first();
        $kehadiran = Kehadiran::whereHas('pegawai', function ($query) use ($nohp) {
            $query->where('nohp', $nohp);
        })
            ->whereDate('waktudatang', Carbon::now())
            ->first();

        return view('pegawai.absensi_pegawai', compact('pegawai', 'kehadiran'));
    }

    public function send_absensi(Request $request)
    {
        $nohp = session('nohp');
        $type = $request->type;
        $dateNow = Carbon::now();

        if ($type === 'waktudatang') {
            Kehadiran::create([
                'nohp' => $nohp,
                'statusgaji' => 0,
                'waktudatang' => $dateNow,
            ]);
        } else {
            Kehadiran::where('nohp', $nohp)
                ->whereDate('waktudatang', $dateNow)
                ->update([
                    'waktupulang' => $dateNow
                ]);
        }

        return redirect()->route('pegawai.absensi');
    }

    public function laporan_gaji_pegawai()
    {
        $nohp = session('nohp');
        $pegawai = Pegawai::where('nohp', $nohp)
            ->with('jabatan')->first();

        $pegawai->calculateJobs();

        return view('pegawai.laporanGaji_pegawai', compact('pegawai'));
    }

    public function laporanKehadiran_pegawai()
    {
        $pegawai = Pegawai::where('nohp', session('nohp'))
            ->with(['kehadiran', 'jabatan'])
            ->first();

        return view('pegawai.laporanKehadiran_pegawai', compact('pegawai'));
    }
}
