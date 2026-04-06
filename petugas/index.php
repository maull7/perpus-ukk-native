<?php
session_start();
if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/index.php");
    exit;
}
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: ../DashboardAdmin/dashboardAdmin.php");
    exit;
}
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "petugas" || !isset($_SESSION["nama_admin"])) {
    header("Location: ../sign/index.php");
    exit;
}
$namaAdmin = $_SESSION["nama_admin"];
require "../config/config.php";
$query = mysqli_query($connection, "SELECT * FROM peminjaman WHERE status = 'Belum konfirmasi' AND nama_admin = '$namaAdmin'");
$peminjaman = [];
while ($data = mysqli_fetch_assoc($query)) $peminjaman[] = $data;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petugas - Perpustakaan</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <a href="signOut.php" class="btn btn-danger">Keluar</a>
    </nav>
    <div class="container-plain page-shell">
        <h1 class="section-title">Konfirmasi peminjaman</h1>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Buku</th>
                        <th>NISN</th>
                        <th>Pinjam</th>
                        <th>Kembali</th>
                        <th>Status/Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjaman as $data) : ?>
                        <tr>
                            <td><?= $data["id_peminjaman"]; ?></td>
                            <td><?= $data["id_buku"]; ?></td>
                            <td><?= $data["nisn"]; ?></td>
                            <td><?= $data["tgl_peminjaman"]; ?></td>
                            <td><?= $data["tgl_pengembalian"]; ?></td>
                            <td><?php if ($data['bukti_transaksi']) : ?><img src="../uploads/<?= htmlspecialchars($data['bukti_transaksi']); ?>" alt="bukti" style="max-width:80px;height:auto;"><?php else : ?>Belum upload<?php endif; ?></td>
                            <td>
                                <?php if ($data['bukti_transaksi']) : ?>
                                    <a href="konfirmasi_peminjaman.php?id=<?= $data['id_peminjaman']; ?>" class="btn btn-success" onclick="return confirm('Approve peminjaman?');">Approve</a>
                                    <a href="tolak_peminjaman.php?id=<?= $data['id_peminjaman']; ?>" class="btn btn-danger" onclick="return confirm('Tolak peminjaman? Status akan jadi Ditolak.');">Tolak</a>
                                <?php else : ?><span>Belum upload bukti</span><?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
</body>

</html>