<?php
session_start();
if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/index.php");
    exit;
}

require "../config/config.php";
$id = (int) ($_GET["id"] ?? 0);
$ref = $_GET["ref"] ?? "petugas";
if ($id > 0) {
    mysqli_query($connection, "UPDATE peminjaman SET status = 'Konfirmasi' WHERE id_peminjaman = $id");
}
if ($ref === "admin") header("Location: ../DashboardAdmin/konfirmasi_peminjaman.php");
else header("Location: index.php");
exit;
