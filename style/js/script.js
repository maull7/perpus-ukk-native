// Logic pengisian input peminjaman buku scr otomatis
function setReturnDate() {
            let borrowDate = new Date(document.getElementById("tgl_peminjaman").value);
            let returnDate = new Date(borrowDate);
            returnDate.setDate(borrowDate.getDate() + 7); // Menambahkan 7 hari

            // Format tanggal pengembalian ke format yyyy-mm-dd
            let formattedDate = returnDate.toISOString().split('T')[0];
            
            document.getElementById("tgl_pengembalian").value = formattedDate;
}
  
// Panggil fungsi hitungDenda saat halaman dimuat
window.onload = function() {
  hitungDenda();
}
