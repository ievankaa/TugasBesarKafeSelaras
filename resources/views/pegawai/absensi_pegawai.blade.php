<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absensi Pegawai</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/pegawai/absensi_pegawai.css') }}">
</head>

@php
  use Carbon\Carbon;
@endphp

<body>
  <div class="container">
    <div class="sidebar">
      <h1 class="sidebar-title">Selaras Cafe</h1>

      <div class="menu-item active">
        <a href="{{ route('pegawai.absensi') }}"><span>Mengisi Kehadiran</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pegawai.laporan_gaji_pegawai') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pegawai.laporanKehadiran_pegawai') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <main>
      <div class="header">
        <p>Selamat datang, <strong>{{ $pegawai->nama_depan }} {{ $pegawai->nama_belakang }}</strong></p>
        <div class="periode">
          <span>Berikut adalah informasi untuk hari ini: <strong>{{ Carbon::now()->format('d M Y') }}</strong></span>
        </div>
      </div>
      <!-- Main Menu - Tombol Absensi -->
      <div class="absensi-container">
        <!-- Info Pegawai -->
        <div class="info-pegawai">
          <img src="/img/barista_fiskaGalih.jpg" alt="Foto Pegawai" class="foto-pegawai">
          <div class="info-detail">
            <p class="jabatan"><span class="badge">{{ $pegawai->jabatan->keterangan }}</span></p>
            <p class="nama-pegawai"><strong>{{ $pegawai->nama_depan }} {{ $pegawai->nama_belakang }}</strong></p>
          </div>
        </div>

        <!-- Info Tanggal dan Waktu -->
        <div class="tanggal-waktu">
          <p class="tanggal" id="tanggalSekarang"></p>
          <p class="waktu" id="waktuSekarang"></p>
        </div>

        <!-- Tombol Absensi -->
        <div class="absensi-buttons">
          @php
            $waktuDatang = $kehadiran->waktudatang ?? null;
            $waktuPulang = $kehadiran->waktupulang ?? null;
          @endphp
          <form method="POST">
            @csrf
            <input type="hidden" name="type" value="waktudatang">
            <button id="btnAbsensiMasuk" class="absensi-btn" type="submit"
              @if ($waktuDatang !== null) disabled @endif>Absensi Masuk</button>
            <p id="statusMasuk" class="status-text"></p>
          </form>

          <form method="POST">
            @csrf
            <input type="hidden" name="type" value="waktupulang">
            <button id="btnAbsensiKeluar" class="absensi-btn" type="submit"
              @if ($waktuDatang === null || $waktuPulang !== null) disabled @endif>Absensi Keluar</button>
            <p id="statusKeluar" class="status-text"></p>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
