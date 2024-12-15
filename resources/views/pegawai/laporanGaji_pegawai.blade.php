<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salary Report</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/laporan_gaji.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/laporanGaji_pegawai.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
</head>

@php
  use Carbon\Carbon;
@endphp


<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h1 class="sidebar-title">Selaras Cafe</h1>

      <div class="menu-item">
        <a href="{{ route('pegawai.absensi') }}"><span>Mengisi Kehadiran</span></a>
      </div>
      <div class="menu-item active">
        <a href="{{ route('pegawai.laporan_gaji_pegawai') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pegawai.laporanKehadiran_pegawai') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <!-- Main Content -->
    <main>
      <div class="header">
        <h1>Selamat datang, {{ $pegawai->nama_depan }} {{ $pegawai->nama_belakang }}!</h1>
        <p>Berikut adalah informasi untuk hari ini: <strong>{{ Carbon::now()->format('d M Y') }}</strong></p>
      </div>

      <div class="info-summary">
        <div class="info-box">
          <span>Total Gaji</span>
          <h2 id="total-gaji">Rp {{ number_format($pegawai->totalGaji, 0, ',', '.') }}</h2>
        </div>
      </div>

      <div class="periode">
        <div class="periode-container">
          <p><strong>Periode</strong></p>
          <input type="date" id="startDate" class="date-picker">
          <span>s.d</span> <input type="date" id="endDate" class="date-picker">
          <select style="padding: 0.5rem 1rem" id="status">
            <option value="" selected>Semua Status</option>
            <option value="1">Terbayarkan</option>
            <option value="0">Belum Terbayarkan
            </option>
          </select>
          <button onclick="applyDateFilter()" class="apply-btn">Terapkan</button>
        </div>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Gaji per Jam</th>
              <th>Jam Kerja</th>
              <th>Total Gaji</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawai->kehadiran as $k)
              @php $k->calculateKehadiran() @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->date }}</td>
                <td>{{ number_format($pegawai->jabatan->gajiperjam, 0, ',', '.') }}</td>
                <td>{{ $k->totalhours }}</td>
                <td>Rp {{ number_format($k->total_salary, 0, ',', '.') }}</td>
                <td>
                  @if ($k->statusgaji === 1)
                    Terbayarkan
                  @else
                    Belum Terbayarkan
                  @endif
                </td>
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
    const totalGajiEl = document.querySelector("#total-gaji");

    const kehadiran = @json($pegawai->kehadiran);

    function applyDateFilter() {
      const startValue = startDateEl.value;
      const endValue = endDateEl.value;
      const statusVal = document.querySelector("select#status option:checked").value;

      if ((startValue !== '' && endValue === '') || (startValue === '' && endValue !== '')) {
        return
      }

      let filterCb = (p) => {
        if (statusVal !== '') {
          return parseInt(statusVal) === p.statusgaji
        }

        return true
      };

      if (startValue !== '') {
        filterCb = (p) => {
          const date = new Date(reverseDate(p.date));
          const startDate = new Date(startValue);
          const endDate = new Date(endValue);

          const dateFilter = startDate <= date && date <= endDate;
          if (statusVal !== '') {
            return parseInt(statusVal) === p.statusgaji && dateFilter;
          }


          return dateFilter;
        }
      }

      rerenderData(filterCb);
    }

    function rerenderData(filterCb) {
      let totalGaji = 0;

      const formattedData = kehadiran.filter(filterCb).map((p, index) => {
        totalGaji += p.total_salary;

        return `
          <tr>
            <td>${index+1}</td>
            <td>${p.date}</td>
            <td>{{ number_format($pegawai->jabatan->gajiperjam, 0, ',', '.') }}</td>
            <td>${p.totalhours}</td>
            <td>Rp ${numberFormat(p.total_salary)}</td>
            <td>${p.statusgaji === 1 ? 'Terbayarkan' : 'Belum Terbayarkan'}</td>
          </tr>
        `;
      });

      totalGajiEl.textContent = `Rp ${numberFormat(totalGaji)}`
      tbody.innerHTML = formattedData.join("");
    }

    function reverseDate(date) {
      if (date === '') {
        return '';
      }

      const [a, b, c] = date.split("-");

      return `${c}-${b}-${a}`;
    }

    function numberFormat(num) {
      return new Intl.NumberFormat('id-ID').format(num)
    }
  </script>
</body>


</html>
