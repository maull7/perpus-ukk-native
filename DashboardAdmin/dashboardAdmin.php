<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/index.php");
    exit;
}
if (isset($_SESSION["role"]) && $_SESSION["role"] === "petugas") {
    header("Location: ../petugas/index.php");
    exit;
}
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../sign/index.php");
    exit;
}
require "../config/config.php";
require "buku/functions.php";
$buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
$kategori = queryReadData("SELECT * FROM kategori_buku ORDER BY kategori ASC");
foreach ($kategori as $kt) {
    if (isset($_POST[$kt['kategori']])) $buku = queryReadData("SELECT * FROM buku WHERE kategori = '" . $kt['kategori'] . "'");
}
if (isset($_POST["search"]) && trim($_POST["keyword"] ?? '') !== '') {
    $buku = searchBuku($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Perpustakaan</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="kategori/index.php">Kategori Buku</a>
                <a href="konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="laporan/index.php">Laporan</a>
                <a href="member/member.php">Member</a>
                <a href="buku/tambahBuku.php">Tambah Buku</a>
                <a href="petugas.php">Petugas</a>
                <a href="signOut.php">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container-plain page-shell">
        <h1 class="section-title">Kelola koleksi buku</h1>
        <form action="" method="post" class="search-bar">
            <input type="text" name="keyword" placeholder="Cari judul, pengarang, atau penerbit…" value="<?= htmlspecialchars($_POST['keyword'] ?? ''); ?>" autocomplete="off">
            <button type="submit" name="search" class="btn btn-primary">Cari</button>
        </form>
        <form action="" method="post">
            <div class="flex-wrap chip-row" style="justify-content:center;">
                <button type="submit">Semua</button>
                <?php foreach ($kategori as $kt) : ?>
                    <button type="submit" name="<?= strtolower($kt['kategori']) ?>"><?= htmlspecialchars($kt['kategori']) ?></button>
                <?php endforeach; ?>
            </div>
        </form>

        <div class="card-grid" style="margin-top:20px;">
            <?php foreach ($buku as $item) : ?>
                <div class="card-item">
                    <a href="#"><img src="../imgDB/<?= htmlspecialchars($item["cover"]); ?>" alt="cover"></a>
                    <div class="body">
                        <strong><?= htmlspecialchars($item["judul"]); ?></strong><br>
                        <small>Kategori: <?= htmlspecialchars($item["kategori"]); ?></small><br>
                        <a href="buku/updateBuku.php?idReview=<?= $item["id_buku"]; ?>" class="btn btn-success">Edit</a>
                        <a href="buku/deleteBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus buku ini?');">Hapus</a>
                    </div>
                </div>
            <?php endforeach; ?>
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