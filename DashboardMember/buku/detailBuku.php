<?php
session_start();
if (!isset($_SESSION["signIn"]) || !isset($_SESSION["member"])) {
    header("Location: ../../sign/index.php");
    exit;
}
if (isset($_SESSION["role"])) {
    header("Location: " . ($_SESSION["role"] === "admin" ? "../../DashboardAdmin/dashboardAdmin.php" : "../../petugas/index.php"));
    exit;
}
require "../../config/config.php";
$idBuku = $_GET["id"] ?? '';
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
$item = $query[0] ?? null;
if (!$item) {
    header("Location: ../dashboardMember.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Buku - Member</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="../formPeminjaman/TransaksiPeminjaman.php">Peminjaman</a>
                <a href="../formPeminjaman/TransaksiPengembalian.php">History</a>
                <a href="../dashboardMember.php">Dashboard</a>
                <a href="../signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Detail Buku</h1>
        <div class="card-plain">
            <img src="../../imgDB/<?= htmlspecialchars($item["cover"]); ?>" alt="cover" style="max-width:200px;height:auto;display:block;margin:0 auto 15px;">
            <p><strong><?= htmlspecialchars($item["judul"]); ?></strong></p>
            <p>ID: <?= htmlspecialchars($item["id_buku"]); ?> | Kategori: <?= htmlspecialchars($item["kategori"]); ?></p>
            <p>Pengarang: <?= htmlspecialchars($item["pengarang"]); ?> | Penerbit: <?= htmlspecialchars($item["penerbit"]); ?></p>
            <p>Tahun: <?= $item["tahun_terbit"]; ?> | Halaman: <?= $item["jumlah_halaman"]; ?></p>
            <p>Deskripsi: <?= htmlspecialchars($item["buku_deskripsi"]); ?></p>
            <a href="../dashboardMember.php" class="btn btn-danger">Batal</a>
            <a href="../formPeminjaman/pinjamBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-success">Pinjam</a>
        </div>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) document.getElementById('menuDropdown').classList.remove('show');
        });
    </script>
</body>

</html>