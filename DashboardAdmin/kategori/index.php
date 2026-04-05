<?php
session_start();
if (!isset($_SESSION["signIn"])) {
    header("Location: ../../sign/index.php");
    exit;
}
if (isset($_SESSION["role"]) && $_SESSION["role"] === "petugas") {
    header("Location: ../../petugas/index.php");
    exit;
}
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../sign/index.php");
    exit;
}
require "../../config/config.php";
require "functions.php";
$kategori = queryReadData("SELECT * FROM kategori_buku ORDER BY kategori");
if (isset($_POST["cari"])) {
    $kw = mysqli_real_escape_string($connection, $_POST["keyword"]);
    $kategori = queryReadData("SELECT * FROM kategori_buku WHERE kategori LIKE '%$kw%' ORDER BY kategori");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori Buku - Admin</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="../dashboardAdmin.php">Dashboard</a>
                <a href="index.php">Kategori Buku</a>
                <a href="../konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="../laporan/index.php">Laporan</a>
                <a href="../member/member.php">Member</a>
                <a href="../buku/tambahBuku.php">Tambah Buku</a>
                <a href="../petugas.php">Petugas</a>
                <a href="../signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Kategori Buku</h1>
        <p><a href="tambah.php" class="btn btn-primary">Tambah Kategori</a> <a href="../dashboardAdmin.php" class="btn">Kembali</a></p>
        <form action="" method="post" class="flex-wrap" style="margin-bottom:15px;">
            <input type="text" name="keyword" placeholder="Cari kategori...">
            <button type="submit" name="cari">Cari</button>
        </form>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kategori as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row["kategori"]); ?></td>
                            <td>
                                <a href="ubah.php?kategori=<?= urlencode($row["kategori"]); ?>" class="btn btn-success">Edit</a>
                                <a href="hapus.php?kategori=<?= urlencode($row["kategori"]); ?>" class="btn btn-danger" onclick="return confirm('Hapus kategori ini? Buku dengan kategori ini juga akan terhapus (CASCADE).');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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