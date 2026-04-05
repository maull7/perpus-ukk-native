<?php

/**
 * Fungsi CRUD kategori buku. Pakai: require config dulu, lalu require file ini.
 */
if (!function_exists('queryReadData')) {
  require_once __DIR__ . '/../../config/config.php';
}

function tambahKategori($kategori)
{
  global $connection;
  $k = mysqli_real_escape_string($connection, trim($kategori));
  if ($k === '') return 0;
  $cek = mysqli_query($connection, "SELECT kategori FROM kategori_buku WHERE kategori = '$k'");
  if (mysqli_num_rows($cek) > 0) return 0;
  mysqli_query($connection, "INSERT INTO kategori_buku (kategori) VALUES ('$k')");
  return mysqli_affected_rows($connection);
}

function updateKategori($kategoriLama, $kategoriBaru)
{
  global $connection;
  $lama = mysqli_real_escape_string($connection, $kategoriLama);
  $baru = mysqli_real_escape_string($connection, trim($kategoriBaru));
  if ($baru === '') return 0;
  mysqli_query($connection, "UPDATE buku SET kategori = '$baru' WHERE kategori = '$lama'");
  mysqli_query($connection, "UPDATE kategori_buku SET kategori = '$baru' WHERE kategori = '$lama'");
  return 1;
}

function deleteKategori($kategori)
{
  global $connection;
  $k = mysqli_real_escape_string($connection, $kategori);
  mysqli_query($connection, "DELETE FROM kategori_buku WHERE kategori = '$k'");
  return mysqli_affected_rows($connection);
}
