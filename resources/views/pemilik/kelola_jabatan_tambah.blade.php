<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jabatan</title>
    <script src="main.js" defer></script>
    <link rel="stylesheet" href="kelola_jabatan.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="menu-item">
                <a href="absensi.html"><span>Absensi Hari Ini</span></a>
            </div>
            <div class="menu-item">
                <a href="laporan_gaji.html"><span>Laporan Gaji</span></a>
            </div>
            <div class="menu-item">
                <a href="laporan_kehadiran.html"><span>Laporan Kehadiran</span></a>
            </div>
            <div class="menu-item active">
                Kelola Data
            </div>
            <!-- Sub-menu -->
            <div class="sub-menu" id="kelolaDataSubMenu">
                <div class="sub-menu-item">
                    <a href="tambah_data.html">Tambah Pegawai</a>
                </div>
                <div class="sub-menu-item">
                    <a href="data_pegawai.html">Data Pegawai</a>
                </div>
                <div class="sub-menu-item active">
                    <a href="kelola_jabatan.html">Kelola Jabatan</a>
                </div>
            </div>
            <div class="menu-item sign-out">
                <a href="{{route('auth.logout')}}"><span>Sign Out</span></a>
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
                    <tr>
                        <td>1</td>
                        <td>Kasir</td>
                        <td>Rp 50.000</td>
                        <td>2</td>
                        <td><button class="details-button" onclick="openDetails('Kasir')">View Details</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Barista</td>
                        <td>Rp 25.000</td>
                        <td>4</td>
                        <td><button class="details-button" onclick="openDetails('Barista')">View Details</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Junior Chef</td>
                        <td>Rp 25.000</td>
                        <td>0</td>
                        <td><button class="details-button" onclick="openDetails('Barista')">View Details</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Popup Tambah Jabatan -->
        <div class="popup hidden" id="popup">
            <div class="popup-content">
                <h2>Tambah Jabatan Baru</h2>
                <form>
                    <div class="form-group">
                        <label for="jabatan">Nama Jabatan</label>
                        <input type="text" id="jabatan" placeholder="e.g. Junior Chef">
                    </div>
                    <div class="form-group">
                        <label for="gaji">Gaji per Jam</label>
                        <input type="number" id="gaji" placeholder="e.g. 50000">
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
                            <th>Total Jam Kerja</th>
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