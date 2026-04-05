<?php
session_start();
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
$query = mysqli_query($connection, "SELECT p.*, b.judul, m.nama as nama_member FROM peminjaman p 
  LEFT JOIN buku b ON p.id_buku = b.id_buku 
  LEFT JOIN member m ON p.nisn = m.nisn 
  WHERE p.status = 'Belum konfirmasi' AND p.bukti_transaksi != '' AND p.bukti_transaksi IS NOT NULL 
  ORDER BY p.id_peminjaman DESC");
$peminjaman = [];
while ($row = mysqli_fetch_assoc($query)) $peminjaman[] = $row;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Peminjaman - Admin</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="dashboardAdmin.php">Dashboard</a>
                <a href="kategori/index.php">Kategori Buku</a>
                <a href="konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="laporan/index.php">Laporan</a>
                <a href="member/member.php">Member</a>
                <a href="buku/tambahBuku.php">Tambah Buku</a>
                <a href="../petugas/index.php">Petugas</a>
                <a href="signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Konfirmasi Peminjaman (Admin)</h1>
        <p>Daftar peminjaman yang sudah upload bukti pembayaran. Approve atau Tolak.</p>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Buku</th>
                        <th>NISN</th>
                        <th>Member</th>
                        <th>Petugas</th>
                        <th>Pinjam</th>
                        <th>Kembali</th>
                        <th>Bukti</th>
                        <th>No Rek Peminjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($peminjaman as $d) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $d["id_peminjaman"]; ?></td>
                            <td><?= htmlspecialchars($d["judul"] ?? $d["id_buku"]); ?></td>
                            <td><?= $d["nisn"]; ?></td>
                            <td><?= htmlspecialchars($d["nama_member"] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($d["nama_admin"]); ?></td>
                            <td><?= $d["tgl_peminjaman"]; ?></td>
                            <td><?= $d["tgl_pengembalian"]; ?></td>
                            <td><img src="../uploads/<?= htmlspecialchars($d['bukti_transaksi']); ?>" alt="bukti" style="max-width:60px;height:auto;"></td>
                            <td>
                                <?= $d['address_norek']; ?>
                            </td>
                            <td>
                                <a href="../petugas/konfirmasi_peminjaman.php?id=<?= $d['id_peminjaman']; ?>&ref=admin" class="btn btn-success" onclick="return confirm('Approve peminjaman?');">Approve</a>
                                <a href="../petugas/tolak_peminjaman.php?id=<?= $d['id_peminjaman']; ?>&ref=admin" class="btn btn-danger" onclick="return confirm('Tolak peminjaman?');">Tolak</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($peminjaman)) : ?><p>Tidak ada peminjaman yang menunggu konfirmasi.</p><?php endif; ?>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) document.getElementById('menuDropdown').classList.remove('show');
        });
    </script>
</body>

</html>