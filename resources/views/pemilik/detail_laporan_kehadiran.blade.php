<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kehadiran Pegawai</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/detail_laporan_kehadiran.css') }}">
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
      <div class="menu-item active">
        <a href="{{ route('pemilik.laporan_kehadiran') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pemilik.tambah_data') }}"><span>Kelola Data</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </aside>

    <!-- Main Content -->
    <main>
      <!-- Employee Info -->
      <div class="employee-info">
        <a href="detail_laporan_kehadiran_fisca.html">
          <img class="profile-picture" src="/img/barista_fiskaGalih.jpg" alt="Fisca Galih">
        </a>
        <div class="info-grid">
          <div><strong>Nama:</strong> {{ $pegawai->nama_depan }} {{ $pegawai->nama_belakang }}</div>
          <div><strong>No. Handphone:</strong> {{ $pegawai->nohp }}</div>
          <div><strong>Alamat:</strong> {{ $pegawai->alamat }} </div>
          <div><strong>Jabatan:</strong> {{ $pegawai->jabatan->keterangan }}</div>
          <div><strong>Email:</strong> {{ $pegawai->email }}</div>
        </div>
        <a href="{{ route('pemilik.laporan_kehadiran') }}"><button class="back">Back</button></a>
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

      <!-- Attendance Table -->
      <div class="table-container">
        <table>
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
            @foreach ($pegawai->kehadiran as $item)
              @php $item->calculateKehadiran() @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->date }}</td>
                <td><span>{{ $item->fwaktuDatang }}</span></td>
                <td><span>{{ $item->fwaktuPulang }}</span></td>
                <td>{{ $item->totalhours }}</td>
              </tr>
            @endforeach
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
