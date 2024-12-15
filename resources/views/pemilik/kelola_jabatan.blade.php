<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Jabatan</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/kelola_jabatan.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
  <script src="{{ asset('js/main.js') }}"></script>
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
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
      <div class="menu-item active">
        Kelola Data
      </div>
      <!-- Sub-menu -->
      <div class="sub-menu" id="kelolaDataSubMenu">
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.tambah_data') }}" class="sub-menu-item">Tambah Pegawai</a>
        </div>
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.datapegawai') }}" class="sub-menu-item">Data Pegawai</a>
        </div>
        <div class="sub-menu-item active">
          <a href="{{ route('pemilik.kelola_jabatan') }}" class="sub-menu-item">Kelola Jabatan</a>
        </div>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <header>
        <h1>Kelola Jabatan</h1>
      </header>
      <button class="add-button" onclick="openPopup()">Tambah Jabatan Baru</button>
      <table class="jabatan-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Jabatan</th>
            <th>Gaji per Jam</th>
            <th>Jumlah Pegawai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jabatanWithPegawai as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->keterangan }}</td>
              <td>Rp. @convert($item->gajiperjam)</td>
              <td>{{ $item->pegawai->count() }}</td>
              <td>
                <button class="details-button"
                  onclick='openDetails("{{ $item->keterangan }}", @json($item->pegawai))'>
                  View Details</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Popup Tambah Jabatan -->
    <div class="popup hidden" id="popup">
      <div class="popup-content">
        <h2>Tambah Jabatan Baru</h2>
        <form method="POST">
          @csrf
          <div class="form-group">
            <label for="jabatan">Nama Jabatan</label>
            <input type="text" id="jabatan" name="keterangan" placeholder="e.g. Junior Chef" required>
          </div>
          <div class="form-group">
            <label for="gaji">Gaji per Jam</label>
            <input type="number" id="gaji" name="gajiperjam" placeholder="e.g. 50000" required>
          </div>
          <button type="button" class="cancel-button" onclick="closePopup()">Cancel</button>
          <button type="submit" class="submit-button">Confirm</button>
        </form>
      </div>
    </div>

    <!-- Popup Details -->
    <div class="popup hidden" id="details-popup">
      <div class="popup-content">
        <h2>Daftar Pegawai</h2>
        <p>Jabatan: <span id="jabatan-name"></span></p>
        <table class="pegawai-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nomor HP</th>
            </tr>
          </thead>
          <tbody id="pegawai-list">
            <!-- Data akan diisi dengan JavaScript -->
          </tbody>
        </table>
        <button type="button" class="cancel-button" onclick="closeDetails()">Close</button>
      </div>
    </div>
  </div>
</body>

</html>
