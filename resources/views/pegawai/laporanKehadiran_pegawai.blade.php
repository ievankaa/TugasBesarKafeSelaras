<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Kehadiran</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/pegawai/laporanKehadiran_pegawai.css') }}">
</head>

<body>
  <div class="container">
    <div class="sidebar">
      <h1 class="sidebar-title">Selaras Cafe</h1>

      <div class="menu-item">
        <a href="{{ route('pegawai.absensi') }}"><span>Mengisi Kehadiran</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pegawai.laporan_gaji_pegawai') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item active">
        <a href="{{ route('pegawai.laporanKehadiran_pegawai') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <main>
      <div class="pegawai-info-container">
        <!-- Informasi Pegawai -->
        <div class="foto-pegawai">
          <img src="/img/barista_fiskaGalih.jpg" alt="Foto Pegawai" class="foto-pegawai">
        </div>
        <div class="info-pegawai">
          <div class="info-row">
            <span class="label">Nama:</span>
            <span class="value">{{ $pegawai->nama_depan }} {{ $pegawai->nama_belakang }}</span>
          </div>
          <div class="info-row">
            <span class="label">No. Handphone:</span>
            <span class="value">{{ $pegawai->nohp }}</span>
          </div>
          <div class="info-row">
            <span class="label">Alamat:</span>
            <span class="value">{{ $pegawai->alamat }}</span>
          </div>
          <div class="info-row">
            <span class="label">Jabatan:</span>
            <span class="value">{{ $pegawai->jabatan->keterangan }}</span>
          </div>
          <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $pegawai->email }}</span>
          </div>
        </div>
      </div>

      <hr class="divider">

      <!-- Container Periode -->
      <div class="periode">
        <div class="periode-container">
          <p><strong>Periode</strong></p>
          <input type="date" id="startDate" class="date-picker">
          <span>s.d</span> <input type="date" id="endDate" class="date-picker">
          <button onclick="applyDateFilter()" class="apply-btn">Terapkan</button>
        </div>
      </div>

      <hr class="divider">

      <!-- Tabel Laporan Kehadiran -->
      <div class="laporan-kehadiran-container">
        <table class="kehadiran-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Keluar</th>
              <th>Total Jam</th>
            </tr>
          </thead>
          <tbody>
            <!-- Data Laporan Kehadiran -->
            @foreach ($pegawai->kehadiran as $k)
              @php $k->calculateKehadiran() @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->date }}</td>
                <td>{{ $k->fwaktuDatang }}</td>
                <td>{{ $k->fwaktuPulang }}</td>
                <td>{{ $k->totalhours }}</td>
              </tr>
            @endforeach
            <!-- Tambah data lainnya sesuai kebutuhan -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
  <script>
    const startDateEl = document.querySelector("#startDate");
    const endDateEl = document.querySelector("#endDate");
    const tbody = document.querySelector("tbody");

    const kehadiran = @json($pegawai->kehadiran);

    function applyDateFilter() {
      const startValue = startDateEl.value;
      const endValue = endDateEl.value;

      if ((startValue !== '' && endValue === '') || (startValue === '' && endValue !== '')) {
        return
      }

      let filterCb = () => true;

      if (startValue !== '') {
        filterCb = (p) => {
          const date = new Date(reverseDate(p.date));
          const startDate = new Date(startValue);
          const endDate = new Date(endValue);

          return startDate <= date && date <= endDate;
        }
      }

      rerenderData(filterCb);
    }

    function rerenderData(filterCb) {
      const formattedData = kehadiran.filter(filterCb).map((p, index) => {
        return `
           <tr>
            <td>${index+1}</td>
            <td>${p.date}</td>
            <td>${p.fwaktuDatang}</td>
            <td>${p.fwaktuPulang}</td>
            <td>${p.totalhours}</td>
          </tr>
        `;
      });

      tbody.innerHTML = formattedData.join("");
    }

    function reverseDate(date) {
      if (date === '') {
        return '';
      }

      const [a, b, c] = date.split("-");

      return `${c}-${b}-${a}`;
    }
  </script>
</body>

</html>
