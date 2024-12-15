// Fungsi untuk toggle visibilitas sub-menu
function toggleSubMenu() {
    const subMenu = document.getElementById('kelolaDataSubMenu');
    // Toggle display antara block dan none
    if (subMenu.style.display === 'none' || subMenu.style.display === '') {
        subMenu.style.display = 'block';  // Menampilkan sub-menu
    } else {
        subMenu.style.display = 'none';   // Menyembunyikan sub-menu
    }
}
