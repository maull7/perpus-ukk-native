<?php
session_start();
if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/index.php");
    exit;
}

require "../config/config.php";
require "../config/peminjaman.php";
$id = (int) ($_GET["id"] ?? 0);
if ($id > 0) tolakPeminjaman($id);
$ref = $_GET["ref"] ?? "petugas";
if ($ref === "admin") header("Location: ../DashboardAdmin/konfirmasi_peminjaman.php");
else header("Location: index.php");
exit;
