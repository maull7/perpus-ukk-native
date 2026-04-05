<?php
require_once "../config/config.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk menghapus data petugas berdasarkan ID
    $sql = "DELETE FROM admin WHERE id=$id";

    if (mysqli_query($connection, $sql)) {
        // Jika query berhasil dijalankan, arahkan kembali ke halaman petugas dengan pesan sukses
        header("Location: petugas.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan, arahkan kembali ke halaman petugas dengan pesan error
        header("Location: petugas.php?status=error");
        exit();
    }
} else {
    // Jika tidak ada ID yang diterima, arahkan kembali ke halaman petugas
    header("Location: petugas.php");
    exit();
}

// Tutup connection
mysqli_close($connection);
