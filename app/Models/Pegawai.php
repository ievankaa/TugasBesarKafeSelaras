<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $guarded = [];
    public $timestamps = false;

    protected $primaryKey = 'nohp';
    protected $keyType = 'string';
    public $incrementing = false;


    public function getRouteKeyName()
    {
        return 'nohp';
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan', 'id_kelurahan');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'nohp', 'nohp');
    }

    public function kehadiranNow()
    {
        return $this->hasOne(Kehadiran::class, 'nohp', 'nohp')
            ->whereDate('waktudatang', Carbon::now());
    }

    public function calculateJob()
    {
        $gajiPerJam = $this->jabatan->gajiperjam;
        $waktuDatang = Carbon::parse($this->kehadiranNow['waktudatang']);
        $waktuPulang = Carbon::parse($this->kehadiranNow['waktupulang']);

        $totalMinutes = $waktuDatang->diffInMinutes($waktuPulang);
        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        $this->total_time = "{$hours} jam {$minutes} menit";
        $this->total_salary = floor($hours) * $gajiPerJam;
    }

    public function calculateJobs()
    {
        $gajiPerJam = $this->jabatan->gajiperjam;
        $totalGaji = 0;

        foreach ($this->kehadiran as &$kehadiran) {
            $waktuDatang = Carbon::parse($kehadiran['waktudatang']);
            $waktuPulang = Carbon::parse($kehadiran['waktupulang']);

            $totalMinutes = $waktuDatang->diffInMinutes($waktuPulang);
            $hours = intdiv($totalMinutes, 60);
            $minutes = $totalMinutes % 60;

            $kehadiran['total_time'] = "{$hours} jam {$minutes} menit";
            $kehadiran['total_salary'] = floor($hours) * $gajiPerJam;
            $totalGaji += $kehadiran['total_salary'];
        }

        $this->totalGaji = $totalGaji;
    }
}
