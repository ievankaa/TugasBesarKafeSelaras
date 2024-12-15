<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    protected $guarded = [];
    public $timestamps = false;

    protected $primaryKey = 'id_kehadiran';

    public function calculateKehadiran()
    {
        $wd = $this->waktudatang;
        $wp = $this->waktupulang;

        $tanggal = Carbon::parse($wd)->format('d-m-Y');
        $waktuDatang = Carbon::parse($wd)->format('H:i');
        $waktuPulang = Carbon::parse($wp)->format('H:i');

        $diffInHours = floor(Carbon::parse($wd)->diffInHours(Carbon::parse($wp)));

        $this->date = $tanggal;
        $this->fwaktuDatang = $waktuDatang;
        $this->fwaktuPulang = $waktuPulang;
        $this->totalhours = $diffInHours;
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nohp', 'nohp');
    }
}
