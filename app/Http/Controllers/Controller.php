<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pegawai;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');

        $adminPhone = '08123456';
        $adminPass = '123456';
        $defaultPass = '123456';

        if ($phone === $adminPhone && $password === $adminPass) {
            session([
                'is_admin' => 1,
                'nohp' => $phone,
            ]);

            return redirect('pemilik/absensi');
        }

        $pegawai = Pegawai::where('nohp', $phone)->first();

        if ($pegawai !== null && $password === $defaultPass) {
            session([
                'is_admin' => 0,
                'nohp' => $phone,
            ]);

            return redirect('pegawai/absensi_pegawai');
        }

        return back()->withErrors(['msg' => 'Nomor Handphone atau Password salah']);
    }

    public function logout()
    {
        request()->session()->flush();

        return redirect()->route('login');
    }

    public function tambah_data()
    {
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all()->groupBy('id_kecamatan')->toArray();
        $jabatan = Jabatan::all();

        return view('pemilik.tambah_data', compact('kecamatan', 'kelurahan', 'jabatan'));
    }

    public function send_data(Request $request)
    {
        Pegawai::create($request->all());

        return redirect()->route('pemilik.datapegawai');
    }

    public function datapegawai()
    {
        $pegawai = Pegawai::with('jabatan')->get();
        return view('pemilik.data_pegawai', compact('pegawai'));
    }

    public function edit_profil(string $nohp)
    {
        $pegawai = Pegawai::where('nohp', $nohp)->with('kelurahan.kecamatan')->firstOrFail();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all()->groupBy('id_kecamatan')->toArray();
        $jabatan = Jabatan::all();

        return view('pemilik.edit_profil', compact('kecamatan', 'kelurahan', 'jabatan', 'pegawai'));
    }

    public function update_profil(Request $request, string $nohp)
    {
        $payload = $request->all();
        unset($payload['_method']);
        unset($payload['_token']);

        Pegawai::where('nohp', $nohp)->update($payload);

        return redirect()->route('pemilik.datapegawai');
    }

    public function kelola_jabatan()
    {
        $jabatanWithPegawai = Jabatan::with('pegawai')->get();
        return view('pemilik.kelola_jabatan', compact('jabatanWithPegawai'));
    }

    public function save_jabatan(Request $request)
    {
        $payload = $request->all();
        unset($payload['_token']);

        Jabatan::create($payload);

        return redirect()->route('pemilik.kelola_jabatan');
    }

    public function detail_laporan_kehadiran(Request $request, string $nohp)
    {
        $pegawai = Pegawai::where('nohp', $nohp)
            ->with(['jabatan', 'kehadiran'])->firstOrFail();

        return view('pemilik.detail_laporan_kehadiran', compact('pegawai'));
    }
}
