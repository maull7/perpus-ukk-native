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
$norek = $_POST['no_rek'] ?? '';
$idPeminjaman = (int) ($_GET['id'] ?? 0);
$pesanBaru = isset($_GET['pesan']) && $_GET['pesan'] == '1';
if ($idPeminjaman <= 0) {
    header("Location: TransaksiPeminjaman.php");
    exit;
}
$dataPinjam = queryReadData("SELECT admin.nama_admin, admin.no_tlp FROM peminjaman INNER JOIN admin ON peminjaman.nama_admin = admin.nama_admin WHERE peminjaman.id_peminjaman = $idPeminjaman");
if (empty($dataPinjam)) {
    header("Location: TransaksiPeminjaman.php");
    exit;
}
$uploadStatus = "";
if (isset($_POST['upload'])) {
    $namaFile = $_FILES['bukti']['name'];
    $fileTmpName = $_FILES['bukti']['tmp_name'];
    $filePath = "../../uploads/" . $namaFile;
    if (move_uploaded_file($fileTmpName, $filePath)) {
        mysqli_query($connection, "UPDATE peminjaman SET bukti_transaksi = '$namaFile', status = 'Belum konfirmasi', address_norek = '$norek' WHERE id_peminjaman = $idPeminjaman");
        $uploadStatus = "success";
        header("Location: TransaksiPeminjaman.php?pesan=upload_success");
        exit;
    } else {
        $uploadStatus = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Bukti - Member</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body onload="typeof uploadStatus!='undefined'&&uploadStatus&&alert(uploadStatus==='success'?'Upload berhasil.':'Upload gagal.');">
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong></span>
        <a href="TransaksiPeminjaman.php" class="btn">Peminjaman</a>
        <a href="../dashboardMember.php" class="btn">Dashboard</a>
        <a href="../signOut.php" class="btn btn-danger">Keluar</a>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Upload Bukti Pembayaran</h1>
        <?php if ($pesanBaru) : ?><p class="alert alert-success">Peminjaman berhasil diajukan. Lakukan pembayaran ke nomor di bawah, lalu upload bukti.</p><?php endif; ?>
        <p style="text-align:center;background:#dfd;padding:10px;">Bayar ke no HP petugas di bawah, lalu upload bukti. Admin/Petugas akan approve atau tolak.</p>
        <?php foreach ($dataPinjam as $item) : ?>
            <div class="card-plain">
                <p><strong>Petugas:</strong> <?= htmlspecialchars($item["nama_admin"]); ?></p>
                <p><strong>Nomor Petugas:</strong> <?= htmlspecialchars($item["no_tlp"]); ?></p>
                <p>
                    <strong>
                        Nomor DANA / E-WALLET : 085157166284
                    </strong>
                </p>
            </div>
        <?php endforeach; ?>
        <div class="card-plain">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Alamat Nomor Rekening Anda</label>
                    <input type="text" name="no_rek" required>
                </div>
                <div class="form-group">
                    <label>Bukti Transaksi (gambar)</label>
                    <input type="file" name="bukti" accept="image/*" required>
                </div>
                <button type="submit" name="upload" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        var uploadStatus = '<?= $uploadStatus; ?>';
    </script>
</body>

</html>