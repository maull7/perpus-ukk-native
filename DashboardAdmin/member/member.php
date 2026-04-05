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
$member = queryReadData("SELECT * FROM member");
if (isset($_POST["search"])) $member = searchMember($_POST["keyword"]);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member - Perpustakaan</title>
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
        <h1 class="section-title">Data Member</h1>
        <form action="" method="post" class="flex-wrap" style="margin-bottom:15px;">
            <a href="tambah.php" class="btn btn-primary">Tambah Member</a>
            <input type="text" name="keyword" placeholder="Cari member...">
            <button type="submit" name="search">Cari</button>
        </form>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No Tlp</th>
                        <th>Pendaftaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($member as $item) : ?>
                        <tr>
                            <td><?= $item["nisn"]; ?></td>
                            <td><?= $item["kode_member"]; ?></td>
                            <td><?= $item["nama"]; ?></td>
                            <td><?= $item["jenis_kelamin"]; ?></td>
                            <td><?= $item["kelas"]; ?></td>
                            <td><?= $item["jurusan"]; ?></td>
                            <td><?= $item["no_tlp"]; ?></td>
                            <td><?= $item["tgl_pendaftaran"]; ?></td>
                            <td><a href="deleteMember.php?id=<?= $item["nisn"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus member?');">Hapus</a></td>
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