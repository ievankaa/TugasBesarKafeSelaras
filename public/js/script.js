//ABSENSI PEGAWAI
// Handle Absensi Masuk and Keluar button clicks
document.addEventListener("DOMContentLoaded", function () {
    const btnMasuk = document.querySelector(".btn-masuk");
    const btnKeluar = document.querySelector(".btn-keluar");

    if (btnMasuk) {
        btnMasuk.addEventListener("click", function () {
            alert("Absensi Masuk berhasil dicatat!");
        });
    }

    if (btnKeluar) {
        btnKeluar.addEventListener("click", function () {
            alert("Absensi Keluar berhasil dicatat!");
        });
    }
});

// Future interactivity for Laporan Gaji
document.addEventListener("DOMContentLoaded", function () {
    const salarySlipBtn = document.querySelector(".salary-slip-btn");

    if (salarySlipBtn) {
        salarySlipBtn.addEventListener("click", function () {
            alert("Slip gaji akan diunduh!");
        });
    }
});

// Fungsi untuk memperbarui waktu sekarang
function updateWaktuSekarang() {
    const sekarang = new Date();
    const waktu = sekarang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById('waktuSekarang').innerText = `${waktu} WIB`;
}

// Jalankan update setiap detik
setInterval(updateWaktuSekarang, 1000);

// Fungsi Absensi Masuk
function absensiMasuk() {
    const sekarang = new Date();
    const jamMasuk = sekarang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

    document.getElementById('statusMasuk').innerText = `Jam Masuk: ${jamMasuk}`;
    document.getElementById('btnAbsensiMasuk').disabled = true; // Disable tombol masuk
    document.getElementById('btnAbsensiKeluar').disabled = false; // Enable tombol keluar
}

// Fungsi Absensi Keluar
function absensiKeluar() {
    const sekarang = new Date();
    const jamKeluar = sekarang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

    document.getElementById('statusKeluar').innerText = `Jam Keluar: ${jamKeluar}`;
    document.getElementById('btnAbsensiKeluar').disabled = true; // Disable tombol keluar
    alert('Absensi berhasil disimpan!');
}
// Fungsi untuk memperbarui tanggal sekarang
function updateTanggalSekarang() {
    const sekarang = new Date();
    const hari = sekarang.toLocaleDateString('id-ID', { weekday: 'long' });
    const tanggal = sekarang.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    document.getElementById('tanggalSekarang').innerText = `${hari}, ${tanggal}`;
}

// Fungsi untuk memperbarui waktu sekarang
function updateWaktuSekarang() {
    const sekarang = new Date();
    const waktu = sekarang.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById('waktuSekarang').innerText = waktu;
}

// Jalankan saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
    updateTanggalSekarang();
    updateWaktuSekarang();
    setInterval(updateWaktuSekarang, 1000);
});

//LAPORAN GAJI

document.addEventListener("DOMContentLoaded", function () {
    loadGajiTable(); // Muat data tabel gaji ketika halaman pertama kali dimuat
});

// Data Gaji (sebagai contoh)
const gajiData = [
    { no: 1, tanggal: '2024-11-01', gajiPerJam: 20000, jamKerja: 8, totalGaji: 200000, status: 'Terbayar' },
    { no: 2, tanggal: '2024-11-02', gajiPerJam: 20000, jamKerja: 9, totalGaji: 220000, status: 'Terbayar' },
    { no: 3, tanggal: '2024-11-03', gajiPerJam: 20000, jamKerja: 4, totalGaji: 160000, status: 'Terbayar' },
    // Tambahkan data lainnya sesuai kebutuhan
];

// Fungsi untuk memuat data ke dalam tabel
function loadGajiTable() {
    const tbody = document.getElementById('gajiTableBody');
    tbody.innerHTML = ''; // Reset table body
    gajiData.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.no}</td>
            <td>${item.tanggal}</td>
            <td>Rp ${item.gajiPerJam}</td>
            <td>${item.jamKerja} jam</td>
            <td>Rp ${item.totalGaji}</td>
            <td>${item.status}</td>
        `;
        tbody.appendChild(row);
    });
}

// Fungsi untuk menerapkan filter periode
function applyDateFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (startDate && endDate) {
        const filteredData = gajiData.filter(item => {
            return item.tanggal >= startDate && item.tanggal <= endDate;
        });

        // Tampilkan data yang difilter
        const tbody = document.getElementById('gajiTableBody');
        tbody.innerHTML = ''; // Reset table body
        filteredData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.no}</td>
                <td>${item.tanggal}</td>
                <td>Rp ${item.gajiPerJam}</td>
                <td>${item.jamKerja} jam</td>
                <td>Rp ${item.totalGaji}</td>
                <td>${item.status}</td>
            `;
            tbody.appendChild(row);
        });
    }
}
