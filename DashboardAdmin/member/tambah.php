<?php
require "../../loginSystem/connect.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");
function getLastMemberCode()
{
    global $conn;
    $q = mysqli_query($conn, "SELECT kode_member FROM member ORDER BY nisn DESC LIMIT 1");
    return $q && ($r = mysqli_fetch_assoc($q)) ? $r['kode_member'] : null;
}
function nextCode($last)
{
    if (!$last) return "mem01";
    return "mem" . str_pad((int)substr($last, 3) + 1, 2, "0", STR_PAD_LEFT);
}
$nextMemberCode = nextCode(getLastMemberCode());
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
if (isset($_POST["signUp"])) {
    $_POST["kode_member"] = $nextMemberCode;
    if (!empty($_POST["tgl_pendaftaran"]) && signUp($_POST) > 0) {
        header("Location: ../dashboardAdmin.php");
        exit;
    }
    echo "<script>alert('Gagal!');</script>";
}
$jurusanList = ["Desain Gambar Mesin", "Teknik Pemesinan", "Teknik Otomotif", "Desain Pemodelan Informasi Bangunan", "Teknik Konstruksi Perumahan", "Teknik Tenaga Listrik", "Teknik Instalasi Tenaga Listrik", "Teknik Komputer Jaringan", "Sistem Informatika Jaringan dan Aplikasi", "Rekayasa Perangkat Lunak", "Desain Komunikasi Visual"];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Member - Admin</title>
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
                <a href="member.php">Member</a>
                <a href="../buku/tambahBuku.php">Tambah Buku</a>
                <a href="../petugas.php">Petugas</a>
                <a href="../dashboardAdmin.php">Dashboard</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Tambah Member</h1>
        <div class="card-plain">
            <form action="" method="post">
                <div class="form-group"><label>NISN</label><input type="number" name="nisn" required></div>
                <div class="form-group"><label>Kode Member</label><input type="text" name="kode_member" value="<?= htmlspecialchars($nextMemberCode); ?>" readonly></div>
                <div class="form-group"><label>Nama</label><input type="text" name="nama" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="confirmPw" required></div>
                <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin">
                        <option value="">Pilih</option>
                        <option value="Laki laki">Laki laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select></div>
                <div class="form-group"><label>Kelas</label><select name="kelas">
                        <option value="">Pilih</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                        <option value="XIII">XIII</option>
                    </select></div>
                <div class="form-group"><label>Jurusan</label><select name="jurusan">
                        <option value="">Pilih</option><?php foreach ($jurusanList as $j) echo "<option value=\"$j\">$j</option>"; ?>
                    </select></div>
                <div class="form-group"><label>No Telepon</label><input type="text" name="no_tlp" required></div>
                <div class="form-group"><label>Tanggal Pendaftaran</label><input type="date" name="tgl_pendaftaran" value="<?= date('Y-m-d'); ?>"></div>
                <button type="submit" name="signUp" class="btn btn-primary">Simpan</button>
                <a href="member.php" class="btn btn-danger">Batal</a>
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