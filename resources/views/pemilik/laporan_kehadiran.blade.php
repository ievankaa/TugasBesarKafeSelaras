<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absensi Pegawai</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/absensi_style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pemilik/data_pegawai.css') }}">
</head>

@php
  use Carbon\Carbon;
@endphp

<body>
  <div class="container">
    <div class="sidebar">
      <h1 class="sidebar-title">Selaras Cafe</h1>
      <div class="menu-item ">
        <a href="{{ route('absensi') }}"><span>Absensi Hari Ini</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('laporan_gaji') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item active">
        <a href="{{ route('pemilik.laporan_kehadiran') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item ">
        <a href="{{ route('pemilik.tambah_data') }}"><span>Kelola Data</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <main>
      <div class="header">
        <h1>Selamat datang, Admin!</h1>
        <p>Berikut adalah informasi untuk hari ini: <strong>{{ Carbon::now()->format('d M Y') }}</strong></p>
      </div>

      <div class="search-bar" style="display: flex; gap: .5rem; align-items: stretch">
        <input type="text" id="searchInput" style="flex: 1" placeholder="Cari pegawai...">
        <button type="button">Cari</button>
      </div>

      <!-- Attendance Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawai as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_depan }} {{ $item->nama_belakang }}</td>
                <td>{{ $item->jabatan->keterangan }}</td>
                <td>
                  <a href="{{ route('pemilik.detail_laporan_kehadiran', ['nohp' => $item->nohp]) }}">
                    <button class="edit-data">View Detail</button>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
  <script>
    const pegawai = @json($pegawai);
    const tbody = document.querySelector("tbody");
    const searchInput = document.querySelector("#searchInput");

    const url = '{{ route('pemilik.detail_laporan_kehadiran') }}';

    document.querySelector(".search-bar button").addEventListener("click", () => {
      const searchedPegawai = pegawai.filter((p) => {
        const name = `${p.nama_depan} ${p.nama_belakang}`.toLowerCase();
        const value = searchInput.value.toLowerCase().trim();

        return name.includes(value);
      }).map((p, index) => {
        return `
          <tr>
            <td>${index+1}</td>
            <td>${p.nama_depan} ${p.nama_belakang}</td>
            <td>${p.jabatan.keterangan}</td>
            <td>
              <a href="${url}/${p.nohp}">
                <button class="edit-data">View Detail</button>
              </a>
            </td>
          </tr>
        `;
      });

      tbody.innerHTML = searchedPegawai.join("");
    })
  </script>
</body>

</html>
