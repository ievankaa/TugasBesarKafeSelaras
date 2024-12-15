<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salary Report</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/laporan_gaji.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pegawai/shared.css') }}">
  <style>
    .edit-data {
      background-color: #d7b89c;
      border: none;
      padding: 8px 12px;
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
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
        <a href="{{ route('absensi') }}"><span>Absensi Hari Ini</span></a>
      </div>
      <div class="menu-item active">
        <a href="{{ route('laporan_gaji') }}"><span>Laporan Gaji</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pemilik.laporan_kehadiran') }}"><span>Laporan Kehadiran</span></a>
      </div>
      <div class="menu-item">
        <a href="{{ route('pemilik.tambah_data') }}"><span>Kelola Data</span></a>
      </div>
      <div class="menu-item sign-out">
        <a href="{{ route('auth.logout') }}"><span>Sign Out</span></a>
      </div>
    </div>

    <!-- Main Content -->
    <main>
      <div class="header">
        <h1>Selamat datang, Admin!</h1>
        <p>Berikut adalah informasi untuk hari ini: <strong>{{ Carbon::now()->format('d M Y') }}</strong></p>
      </div>

      <div class="info-summary">
        <div class="info-box">
          <span>Total Gaji</span>
          <h2 id="total-gaji">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h2>
        </div>
      </div>

      <div class="periode">
        <div class="periode-container">
          <p><strong>Periode</strong></p>
          <input type="date" id="startDate" class="date-picker">
          <span>s.d</span> <input type="date" id="endDate" class="date-picker">
          <button onclick="applyDateFilter()" class="apply-btn">Terapkan</button>
        </div>
      </div>

      <div class="search-bar" style="display: flex; gap: 0.5rem; align-items: stretch">
        <div style="flex: 1">
          <input type="text" id="searchInput" style="width: calc(100% - 20px)" placeholder="Cari pegawai...">
        </div>
        <select style="padding: 0.5rem 1rem" id="status">
          <option value="" selected>Semua Status</option>
          <option value="1">Terbayarkan</option>
          <option value="0">Belum Terbayarkan
          </option>
        </select>
        <button type="button" style="padding: 0.5rem 1rem">Cari</button>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Gaji per Jam</th>
              <th>Total Jam Kerja</th>
              <th>Total Gaji</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawai as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_depan }} {{ $item->nama_belakang }}</td>
                <td>{{ $item->jabatan->keterangan }}</td>
                <td>{{ $item->gajiPerJam }}</td>
                <td>{{ $item->total_time ?? '-' }}</td>
                <td>{{ $item->total_salary ?? '-' }}
                </td>
                <td>
                  @if (($item->kehadiranNow->statusgaji ?? null) === 1)
                    Terbayarkan
                  @else
                    Belum Terbayarkan
                  @endif
                </td>
                <td>
                  @if (($item->kehadiranNow->statusgaji ?? 1) !== 1)
                    <form method="POST">
                      @csrf
                      <input type="hidden" name="idKehadiran" value="{{ $item->kehadiranNow->id_kehadiran }}">
                      <button class="edit-data">Bayar</button>
                    </form>
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
    const pegawai = @json($pegawai);
    const tbody = document.querySelector("tbody");
    const searchInput = document.querySelector("#searchInput");
    const totalGajiEl = document.querySelector("#total-gaji");
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
            <td>{{ $item->total_salary ?? '-' }}</td>
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
    document.querySelector(".search-bar button").addEventListener("click", () => {
      const statusVal = document.querySelector("select#status option:checked").value;
      let totalGaji = 0;

      const searchedPegawai = pegawai.filter((p) => {
        const name = `${p.nama_depan} ${p.nama_belakang}`.toLowerCase();
        const value = searchInput.value.toLowerCase().trim();

        const isIncludes = name.includes(value);

        if (statusVal !== '') {
          let statuses = [1]
          if (statusVal === '0') statuses = [undefined, 0];

          return isIncludes && (statuses.includes(p?.kehadiran_now?.statusgaji))
        }

        return isIncludes
      }).map((p, index) => {
        if (!!p.total_salary) {
          totalGaji += parseInt(p.total_salary.replace(/[^0-9]/g, ''), 10);
        }

        return `
           <tr>
            <td>${index+1}</td>
            <td>${p.nama_depan} ${p.nama_belakang}</td>
            <td>${p.jabatan.keterangan}</td>
            <td>${p.gajiPerJam}</td>
            <td>${p.total_time ?? '-'}</td>
            <td>${p.total_salary ?? '-'}</td>
            <td>${p?.kehadiran_now?.statusgaji === undefined ? '-' : p?.kehadiran_now?.statusgaji === 1 ? 'Terbayarkan' : 'Belum Terbayarkan'}</td>
            <td>
              ${p?.kehadiran_now?.statusgaji === 0 ? `
                  <form method="POST">
                    @csrf
                    <input type="hidden" name="idKehadiran" value="${p.kehadiran_now.id_kehadiran}">
                    <button class="edit-data">Bayar</button>
                  </form>
                ` : ''}
            </td>
          </tr>
        `;
      });

      totalGajiEl.textContent = `Rp ${numberFormat(totalGaji)}`
      tbody.innerHTML = searchedPegawai.join("");
    })

    function numberFormat(num) {
      return new Intl.NumberFormat('id-ID').format(num)
    }
  </script>
</body>


</html>
