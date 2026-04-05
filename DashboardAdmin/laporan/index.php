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

$tanggal_dari = $_GET["tanggal_dari"] ?? '';
$tanggal_sampai = $_GET["tanggal_sampai"] ?? '';
$laporan = [];
$filter_aktif = ($tanggal_dari !== '' && $tanggal_sampai !== '');

$sql = "SELECT p.*, b.judul, b.pengarang, b.penerbit, m.nama as nama_member 
  FROM peminjaman p 
  LEFT JOIN buku b ON p.id_buku = b.id_buku 
  LEFT JOIN member m ON p.nisn = m.nisn ";
if ($filter_aktif) {
    $dari = mysqli_real_escape_string($connection, $tanggal_dari);
    $sampai = mysqli_real_escape_string($connection, $tanggal_sampai);
    $sql .= " WHERE p.tgl_peminjaman >= '$dari' AND p.tgl_peminjaman <= '$sampai' ";
}
$sql .= " ORDER BY p.tgl_peminjaman DESC, p.id_peminjaman DESC";
$query = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($query)) $laporan[] = $row;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman - Admin</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="../dashboardAdmin.php">Dashboard</a>
                <a href="../kategori/index.php">Kategori Buku</a>
                <a href="../konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="index.php">Laporan</a>
                <a href="../member/member.php">Member</a>
                <a href="../buku/tambahBuku.php">Tambah Buku</a>
                <a href="../petugas.php">Petugas</a>
                <a href="../signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Laporan Peminjaman</h1>
        <div class="card-plain" style="margin-bottom:20px;">
            <form action="" method="get" style="display:flex;flex-wrap:wrap;align-items:flex-end;gap:12px;">
                <div class="form-group" style="margin:0;">
                    <label>Tanggal dari</label>
                    <input type="date" name="tanggal_dari" value="<?= htmlspecialchars($tanggal_dari); ?>">
                </div>
                <div class="form-group" style="margin:0;">
                    <label>Tanggal sampai</label>
                    <input type="date" name="tanggal_sampai" value="<?= htmlspecialchars($tanggal_sampai); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <?php if ($filter_aktif) : ?>
                    <a href="index.php" class="btn">Tampilkan Semua</a>
                <?php endif; ?>
            </form>
        </div>

        <p><strong><?= $filter_aktif ? 'Periode:' : 'Semua riwayat'; ?></strong>
            <?php if ($filter_aktif) : ?>
                <?= htmlspecialchars($tanggal_dari); ?> s/d <?= htmlspecialchars($tanggal_sampai); ?>
            <?php endif; ?>
            — Jumlah: <?= count($laporan); ?> transaksi
        </p>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>NISN</th>
                        <th>Member</th>
                        <th>Petugas</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($laporan as $d) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $d["id_peminjaman"]; ?></td>
                            <td><?= htmlspecialchars($d["judul"] ?? $d["id_buku"]); ?></td>
                            <td><?= htmlspecialchars($d["pengarang"] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($d["penerbit"] ?? '-'); ?></td>
                            <td><?= $d["nisn"]; ?></td>
                            <td><?= htmlspecialchars($d["nama_member"] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($d["nama_admin"]); ?></td>
                            <td><?= $d["tgl_peminjaman"]; ?></td>
                            <td><?= $d["tgl_pengembalian"]; ?></td>
                            <td><?= htmlspecialchars($d["status"]); ?></td>
                            <td><?= number_format($d["harga"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($laporan)) : ?>
            <p>Tidak ada data peminjaman.</p>
        <?php endif; ?>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) document.getElementById('menuDropdown').classList.remove('show');
        });
    </script>
</body>

</html>