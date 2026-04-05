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
$kategori = $_GET["kategori"] ?? '';
if ($kategori !== '') {
    deleteKategori($kategori);
}
header("Location: index.php");
exit;
