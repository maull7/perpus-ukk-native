<?php
session_start();
if (!isset($_SESSION["signIn"]) || !isset($_SESSION["member"])) {
    header("Location: ../sign/index.php");
    exit;
}
if (isset($_SESSION["role"]) && ($_SESSION["role"] === "admin" || $_SESSION["role"] === "petugas")) {
    header("Location: " . ($_SESSION["role"] === "admin" ? "../DashboardAdmin/dashboardAdmin.php" : "../petugas/index.php"));
    exit;
}
require "../config/config.php";
require "../DashboardAdmin/buku/functions.php";
$buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
$kategori = queryReadData("SELECT * FROM kategori_buku ORDER BY kategori ASC");
foreach ($kategori as $kt) {
    if (isset($_POST[$kt['kategori']])) $buku = queryReadData("SELECT * FROM buku WHERE kategori = '" . $kt['kategori'] . "'");
}
if (isset($_POST["search"])) $buku = searchBuku($_POST["keyword"]);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member - Perpustakaan</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="formPeminjaman/TransaksiPeminjaman.php">Peminjaman</a>
                <a href="formPeminjaman/TransaksiPengembalian.php">History</a>
                <a href="signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">DAFTAR BUKU</h1>
        <form action="" method="post" style="text-align:center;margin-bottom:15px;">
            <input type="text" name="keyword" placeholder="Cari buku...">
            <button type="submit" name="search">Cari</button>
        </form>
        <form action="" method="post">
            <div class="flex-wrap" style="justify-content:center;">
                <button type="submit">Semua</button>
                <?php foreach ($kategori as $kt) : ?>
                    <button type="submit" name="<?= strtolower($kt['kategori']) ?>"><?= htmlspecialchars($kt['kategori']) ?></button>
                <?php endforeach; ?>
            </div>
        </form>
        <div class="card-grid" style="margin-top:20px;">
            <?php foreach ($buku as $item) : ?>
                <div class="card-item">
                    <a href="buku/detailBuku.php?id=<?= $item["id_buku"]; ?>"><img src="../imgDB/<?= htmlspecialchars($item["cover"]); ?>" alt="cover"></a>
                    <div class="body">
                        <strong><?= htmlspecialchars($item["judul"]); ?></strong><br>
                        <small>Kategori: <?= htmlspecialchars($item["kategori"]); ?></small><br>
                        <a href="buku/detailBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-warning">Detail</a>
                        <a href="formPeminjaman/pinjamBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-success">Pinjam</a>
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