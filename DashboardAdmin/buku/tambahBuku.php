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
$kategori = queryReadData("SELECT * FROM kategori_buku");
$query = mysqli_query($connection, "SELECT max(id_buku) as kodeTerbesar FROM buku");
$dataid = mysqli_fetch_array($query);
$kodebuku = $dataid['kodeTerbesar'] ?? 'BK0000';
$urutan = (int) substr($kodebuku, -4, 4);
$urutan++;
$kodebuku = "BK" . sprintf("%04s", $urutan);
if (isset($_POST["tambah"])) {
    if (tambahBuku($_POST) > 0) {
        header("Location: ../dashboardAdmin.php");
        exit;
    }
    echo "<script>alert('Gagal menambah buku!');</script>";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Buku - Admin</title>
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
        <h1 class="section-title">Tambah Buku</h1>
        <div class="card-plain">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group"><label>Cover Buku</label><input type="file" name="cover" required></div>
                <div class="form-group"><label>ID Buku</label><input type="text" name="id_buku" value="<?= htmlspecialchars($kodebuku); ?>"></div>
                <div class="form-group"><label>Kategori</label><select name="kategori">
                        <option value="">Pilih</option><?php foreach ($kategori as $item) : ?><option><?= $item["kategori"]; ?></option><?php endforeach; ?>
                    </select></div>
                <div class="form-group"><label>Judul</label><input type="text" name="judul" required></div>
                <div class="form-group"><label>Pengarang</label><input type="text" name="pengarang" required></div>
                <div class="form-group"><label>Penerbit</label><input type="text" name="penerbit" required></div>
                <div class="form-group"><label>Tahun Terbit</label><input type="date" name="tahun_terbit" required></div>
                <div class="form-group"><label>Jumlah Halaman</label><input type="number" name="jumlah_halaman" required></div>
                <div class="form-group"><label>Sinopsis</label><textarea name="buku_deskripsi"></textarea></div>
                <div class="form-group"><label>Isi Buku (PDF)</label><input type="file" name="isi_buku" accept=".pdf" required></div>
                <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
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