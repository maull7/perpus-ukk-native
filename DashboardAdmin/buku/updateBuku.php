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
$review = $_GET["idReview"];
$reviewData = queryReadData("SELECT * FROM buku WHERE id_buku = '$review'")[0];
$kategori = queryReadData("SELECT * FROM kategori_buku");
if (isset($_POST["update"])) {
    if (updateBuku($_POST) > 0) {
        echo "<script>alert('Buku berhasil diupdate!'); location.href='../dashboardAdmin.php';</script>";
        exit;
    }
    echo "<script>alert('Gagal diupdate!');</script>";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Buku - Admin</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="../kategori/index.php">Kategori Buku</a>
                <a href="../konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="../laporan/index.php">Laporan</a>
                <a href="../member/member.php">Member</a>
                <a href="tambahBuku.php">Tambah Buku</a>
                <a href="../petugas.php">Petugas</a>
                <a href="../dashboardAdmin.php">Dashboard</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Edit Buku</h1>
        <div class="card-plain">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="coverLama" value="<?= htmlspecialchars($reviewData["cover"]); ?>">
                <div class="form-group">
                    <label>Cover (saat ini)</label>
                    <img src="../../imgDB/<?= htmlspecialchars($reviewData["cover"]); ?>" width="80" height="80" alt="cover"><br>
                    <label>Ganti cover</label>
                    <input type="file" name="cover">
                </div>
                <div class="form-group"><label>ID Buku</label><input type="text" name="id_buku" value="<?= htmlspecialchars($reviewData["id_buku"]); ?>"></div>
                <div class="form-group"><label>Kategori</label><select name="kategori"><?php foreach ($kategori as $item) : ?><option <?= $item["kategori"] === $reviewData["kategori"] ? 'selected' : ''; ?>><?= $item["kategori"]; ?></option><?php endforeach; ?></select></div>
                <div class="form-group"><label>Judul</label><input type="text" name="judul" value="<?= htmlspecialchars($reviewData["judul"]); ?>"></div>
                <div class="form-group"><label>Pengarang</label><input type="text" name="pengarang" value="<?= htmlspecialchars($reviewData["pengarang"]); ?>"></div>
                <div class="form-group"><label>Penerbit</label><input type="text" name="penerbit" value="<?= htmlspecialchars($reviewData["penerbit"]); ?>"></div>
                <div class="form-group"><label>Tahun Terbit</label><input type="date" name="tahun_terbit" value="<?= $reviewData["tahun_terbit"]; ?>"></div>
                <div class="form-group"><label>Jumlah Halaman</label><input type="number" name="jumlah_halaman" value="<?= $reviewData["jumlah_halaman"]; ?>"></div>
                <div class="form-group"><label>Sinopsis</label><textarea name="buku_deskripsi"><?= htmlspecialchars($reviewData["buku_deskripsi"]); ?></textarea></div>
                <button type="submit" name="update" class="btn btn-success">Simpan</button>
                <a href="../dashboardAdmin.php" class="btn btn-danger">Batal</a>
            </form>
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