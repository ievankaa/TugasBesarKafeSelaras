<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/pemilik/tambah_data.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
  <title>Tambah Pegawai Baru</title>
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
      <div class="menu-item active" onclick="toggleSubMenu()">
        Kelola Data
      </div>
      <!-- Sub-menu (hidden by default) -->
      <div class="sub-menu" id="kelolaDataSubMenu">
        <div class="sub-menu-item active" id="tambahPegawaiButton">
          Tambah Pegawai
        </div>
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.datapegawai') }}" class="sub-menu-item">Data Pegawai</a>
        </div>
        <div class="sub-menu-item">
          <a href="{{ route('pemilik.kelola_jabatan') }}" class="sub-menu-item">Kelola Jabatan</a>
        </div>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
      <header>
        <h1>Tambah Pegawai Baru</h1>
      </header>
      <form method="POST">
        @csrf
        <div class="form-group">
          <label for="namaDepan">Nama Depan</label>
          <input type="text" name="nama_depan" id="namaDepan" placeholder="e.g John" required>
        </div>
        <div class="form-group">
          <label for="namaBelakang">Nama Belakang</label>
          <input type="text" name="nama_belakang" id="namaBelakang" placeholder="e.g Doe" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="e.g john.doe@example.com" required>
        </div>
        <div class="form-group">
          <label for="nomorHp">Nomor Handphone</label>
          <input type="text" name="nohp" id="nomorHp" placeholder="e.g 08123456789" required>
        </div>
        <div class="form-group">
          <label for="kecamatan">Kecamatan</label>
          <select id="kecamatan" onchange="updateKelurahan()" required>
            <option value="" disabled selected>Pilih Kecamatan</option>
            @foreach ($kecamatan as $k)
              <option value="{{ $k->id_kecamatan }}">{{ $k->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="kelurahan">Kelurahan</label>
          <select id="kelurahan" name="id_kelurahan" disabled required>
            <option value="" disabled selected>Pilih Kelurahan</option>
          </select>
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <input type="text" id="Alamat" name="alamat" placeholder="e.g Jl. Merdeka no.141" required>
        </div>
        <div class="form-group">
          <label for="Jabatan">Jabatan</label>
          <select id="jabatan" name="id_jabatan" required>
            <option value="" disabled selected>Pilih Jabatan</option>
            @foreach ($jabatan as $j)
              <option value="{{ $j->id_jabatan }}">{{ $j->keterangan }}</option>
            @endforeach
          </select>
        </div>
        <input type="hidden" name="statusaktif" value="1">
        <div class="form-buttons">
          <button type="submit" class="submit-button">Simpan</button>
        </div>
      </form>
    </main>
  </div>
  <script>
    // Data for Kecamatan and Kelurahan
    const dataKecamatan = @json($kelurahan);

    // Update Kelurahan Dropdown
    function updateKelurahan() {
      const kecamatan = document.getElementById("kecamatan").value;
      const kelurahanDropdown = document.getElementById("kelurahan");
      kelurahanDropdown.innerHTML = '<option value="" disabled selected>Pilih Kelurahan</option>';
      kelurahanDropdown.disabled = false;

      if (dataKecamatan[kecamatan]) {
        dataKecamatan[kecamatan].forEach(kelurahan => {
          const option = document.createElement("option");
          option.value = kelurahan.id_kelurahan;
          option.textContent = kelurahan.nama;
          kelurahanDropdown.appendChild(option);
        });
      }
    }

    // Function to toggle visibility of the sub-menu
    function toggleSubMenu() {
      const subMenu = document.getElementById('kelolaDataSubMenu');
      // Toggle display between block and none
      if (subMenu.style.display === 'none' || subMenu.style.display === '') {
        subMenu.style.display = 'block'; // Show sub-menu
      } else {
        subMenu.style.display = 'none'; // Hide sub-menu
      }
    }
  </script>
</body>

</html>
