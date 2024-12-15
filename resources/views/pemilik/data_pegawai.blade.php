<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Pegawai</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/data_pegawai.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h1 class="sidebar-title">Selaras Cafe</h1>
      <div class="menu-item">
        <a href="{{ route('absensi') }}"><span>Absensi Hari Ini</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('laporan_gaji') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pemilik.laporan_kehadiran') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item active" onclick="toggleSubMenu()">
        Kelola Data
      </div>
      <!-- Sub-menu (hidden by default) -->
      <div class="sub-menu" id="kelolaDataSubMenu">
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.tambah_data') }}" class="sub-menu-item">Tambah Pegawai</a>
        </div>
        <div class="sub-menu-item active">
          <a href="{{ route('pemilik.datapegawai') }}" class="sub-menu-item">Data Pegawai</a>
        </div>
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.kelola_jabatan') }}" class="sub-menu-item">Kelola Jabatan</a>
        </div>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </aside>

    <!-- Main Content -->
    <main>
      <!-- Search bar -->
      <div class="search-bar" style="display: flex; gap: .5rem; align-items: stretch">
        <input type="text" id="searchInput" style="flex: 1" placeholder="Cari pegawai...">
        <button type="button">Cari</button>
      </div>

      <!-- Employee Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nomor Handphone</th>
              <th>Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawai as $p)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_depan }} {{ $p->nama_belakang }}</td>
                <td>{{ $p->nohp }}</td>
                <td>{{ $p->jabatan->keterangan }}</td>
                <td>
                  <a href="{{ route('pemilik.edit_profil', ['nohp' => $p->nohp]) }}">
                    <button class="edit-data">Edit Profil</button>
                  </a>
                </td>
              </tr>
            @endforeach
            <!-- Tambahkan baris lainnya -->
          </tbody>
        </table>
      </div>

    </main>
  </div>

  <script>
    const pegawai = @json($pegawai);
    const tbody = document.querySelector("tbody");
    const searchInput = document.querySelector("#searchInput");

    const url = '{{ route('pemilik.edit_profil') }}';

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
            <td>${p.nohp}</td>
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
