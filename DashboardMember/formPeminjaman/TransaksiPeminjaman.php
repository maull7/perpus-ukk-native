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
require "../../config/peminjaman.php";
pengembalian();
$akunMember = $_SESSION["member"]["nisn"];
$dataPinjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian, peminjaman.status, buku.isi_buku, harga, peminjaman.bukti_transaksi
  FROM peminjaman INNER JOIN buku ON peminjaman.id_buku = buku.id_buku INNER JOIN member ON peminjaman.nisn = member.nisn INNER JOIN admin ON peminjaman.nama_admin = admin.nama_admin
  WHERE peminjaman.nisn = '$akunMember' AND peminjaman.status IN ('Konfirmasi', 'Belum konfirmasi', 'Ditolak')");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman - Member</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="TransaksiPeminjaman.php">Peminjaman</a>
                <a href="TransaksiPengembalian.php">History</a>
                <a href="../dashboardMember.php">Dashboard</a>
                <a href="../signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Riwayat Peminjaman</h1>
        <p style="text-align:center;background:#ffc;padding:10px;">Jika belum konfirmasi, lakukan pembayaran ke nomor yang tertera di tabel.</p>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Buku</th>
                        <th>Judul</th>
                        <th>Nama</th>
                        <th>Admin</th>
                        <th>Pinjam</th>
                        <th>Berakhir</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataPinjam as $item) : ?>
                        <tr>
                            <td><?= $item["id_peminjaman"]; ?></td>
                            <td><?= $item["id_buku"]; ?></td>
                            <td><?= htmlspecialchars($item["judul"]); ?></td>
                            <td><?= htmlspecialchars($item["nama"]); ?></td>
                            <td><?= htmlspecialchars($item["nama_admin"]); ?></td>
                            <td><?= $item["tgl_peminjaman"]; ?></td>
                            <td><?= $item["tgl_pengembalian"]; ?></td>
                            <td>Rp <?= number_format($item["harga"]); ?></td>
                            <td>
                                <?php if ($item["status"] == 'Konfirmasi') : ?>
                                    <a href="bacabuku.php?pdf=<?= urlencode($item["isi_buku"]); ?>" class="btn btn-primary">Baca</a>
                                    <a href="pinjam.php?id=<?= $item['id_peminjaman']; ?>" class="btn btn-success">Kembalikan</a>
                                <?php elseif ($item["status"] == 'Belum konfirmasi') : ?>
                                    <?php if (!empty($item['bukti_transaksi'])) : ?>Tunggu approve admin/petugas
                                <?php else : ?><a href="upload_bukti.php?id=<?= $item['id_peminjaman']; ?>" class="btn btn-warning">Upload Bukti</a><?php endif; ?>
                            <?php elseif ($item["status"] == 'Ditolak') : ?>
                                <span style="color:#c33;">Ditolak.</span> <a href="upload_bukti.php?id=<?= $item['id_peminjaman']; ?>" class="btn btn-warning">Upload Bukti Ulang</a>
                            <?php endif; ?>
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