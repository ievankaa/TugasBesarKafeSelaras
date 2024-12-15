// Fungsi untuk toggle password visibility
function togglePassword() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.querySelector('.eye-icon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.textContent = '👁️'; // Change icon to show password
    } else {
        passwordField.type = 'password';
        eyeIcon.textContent = '👁️'; // Change icon to hide password
    }
}

// Event listener untuk tombol sign in
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('signInButton').addEventListener('click', (e) => {
        e.preventDefault(); // Mencegah aksi default form submission

        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;

        if (phone && password) {
            // Arahkan ke halaman absensi.html jika nomor handphone dan password valid
            window.location.href = 'absensi.html';
        } else {
            alert('Masukkan nomor handphone dan password!');
        }
    });
});
// Fungsi untuk membuka popup Tambah Jabatan Baru
function openPopup() {
    const popup = document.getElementById('popup');
    popup.classList.remove('hidden'); // Menampilkan popup
}

// Fungsi untuk menutup popup Tambah Jabatan Baru
function closePopup() {
    const popup = document.getElementById('popup');
    popup.classList.add('hidden'); // Menyembunyikan popup
}

// Fungsi untuk membuka popup Details
function openDetails(jabatan) {
    const detailsPopup = document.getElementById('details-popup');
    const jabatanName = document.getElementById('jabatan-name');
    const pegawaiList = document.getElementById('pegawai-list');

    jabatanName.textContent = jabatan;
    pegawaiList.innerHTML = '';

    const data = pegawaiData[jabatan] || [];
    data.forEach((pegawai) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${pegawai.no}</td>
            <td>${pegawai.nama}</td>
            <td>${pegawai.nomorHp}</td>
            <td>${pegawai.totalJamKerja}</td>
        `;
        pegawaiList.appendChild(row);
    });

    detailsPopup.classList.remove('hidden'); // Menampilkan popup
}

// Fungsi untuk menutup popup Details
function closeDetails() {
    const detailsPopup = document.getElementById('details-popup');
    detailsPopup.classList.add('hidden'); // Menyembunyikan popup
}

// Data pegawai untuk setiap jabatan
const pegawaiData = {
    Kasir: [
        { no: 1, nama: 'John Doe', nomorHp: '081234567890', totalJamKerja: 40 },
        { no: 2, nama: 'Jane Smith', nomorHp: '081234567891', totalJamKerja: 35 },
    ],
    Barista: [
        { no: 1, nama: 'Alice', nomorHp: '081234567892', totalJamKerja: 50 },
        { no: 2, nama: 'Bob', nomorHp: '081234567893', totalJamKerja: 48 },
    ],
};
