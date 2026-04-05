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
$bukuId = $_GET["id"];
if (deleteBuku($bukuId) > 0) {
  echo "
  <script>
  alert('Data buku berhasil dihapus');
  document.location.href = '../dashboardAdmin.php';
  </script>";
} else {
  echo "
  <script>
  alert('Data buku gagal dihapus');
  document.location.href = '../dashboardAdmin.php';
  </script>";
}
