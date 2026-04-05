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
$pdfFile = isset($_GET['pdf']) ? basename(urldecode($_GET['pdf'])) : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baca Buku</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong></span>
        <a href="TransaksiPeminjaman.php" class="btn">Peminjaman</a>
        <a href="../dashboardMember.php" class="btn">Dashboard</a>
        <a href="../signOut.php" class="btn btn-danger">Keluar</a>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Baca Buku</h1>
        <?php if ($pdfFile) : ?>
            <embed src="../../isi-buku/<?= htmlspecialchars($pdfFile); ?>" type="application/pdf" style="width:100%;height:70vh;border:1px solid #ccc;" />
        <?php else : ?>
            <p>File tidak ditemukan.</p>
        <?php endif; ?>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
</body>

</html>