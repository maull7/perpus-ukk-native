<?php

/**
 * Fungsi CRUD & search buku. Pakai: require config dulu, lalu require file ini.
 */
if (!function_exists('queryReadData')) {
  require_once __DIR__ . '/../../config/config.php';
}

function upload_cover_buku()
{
  global $connection;
  $namaFile = $_FILES["cover"]["name"];
  $ukuranFile = $_FILES["cover"]["size"];
  $error = $_FILES["cover"]["error"];
  $tmpName = $_FILES["cover"]["tmp_name"];
  if ($error === 4) {
    echo "<script>alert('Silahkan upload cover buku terlebih dahulu!');</script>";
    return 0;
  }
  $formatGambarValid = ['jpg', 'jpeg', 'png', 'svg', 'bmp', 'psd', 'tiff'];
  $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
  if (!in_array($ekstensiGambar, $formatGambarValid)) {
    echo "<script>alert('Format file tidak sesuai');</script>";
    return 0;
  }
  if ($ukuranFile > 2000000) {
    echo "<script>alert('Ukuran file terlalu besar!');</script>";
    return 0;
  }
  $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
  $dirImg = __DIR__ . '/../../imgDB/';
  move_uploaded_file($tmpName, $dirImg . $namaFileBaru);
  return $namaFileBaru;
}

function upload_isi_buku()
{
  $namaFile = $_FILES['isi_buku']['name'];
  $x = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($x));
  $ukuranFile = $_FILES['isi_buku']['size'];
  $file_tmp = $_FILES['isi_buku']['tmp_name'];
  $dirUpload = __DIR__ . '/../../isi-buku/';
  $linkBerkas = $dirUpload . $namaFile;
  if ($ekstensiFile !== 'pdf') {
    echo "<script>alert('Hanya file PDF yang diperbolehkan.');</script>";
    return 0;
  }
  if ($ukuranFile > 20000000000) {
    echo "<script>alert('Ukuran file terlalu besar.');</script>";
    return 0;
  }
  if (move_uploaded_file($file_tmp, $linkBerkas)) return $namaFile;
  echo "<script>alert('Gagal mengunggah file.');</script>";
  return 0;
}

function tambahBuku($dataBuku)
{
  global $connection;
  $cover = upload_cover_buku();
  $idBuku = htmlspecialchars($dataBuku["id_buku"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["buku_deskripsi"]);
  $isi_buku = upload_isi_buku();
  if (!$cover || !$isi_buku) return 0;
  $q = "INSERT INTO buku VALUES('$cover', '$idBuku', '$kategoriBuku', '$judulBuku', '$pengarangBuku', '$penerbitBuku', '$tahunTerbit', $jumlahHalaman, '$deskripsiBuku','$isi_buku')";
  mysqli_query($connection, $q);
  return mysqli_affected_rows($connection);
}

function updateBuku($dataBuku)
{
  global $connection;
  $gambarLama = htmlspecialchars($dataBuku["coverLama"]);
  $idBuku = htmlspecialchars($dataBuku["id_buku"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["buku_deskripsi"]);
  $cover = ($_FILES["cover"]["error"] === 4) ? $gambarLama : upload_cover_buku();
  $q = "UPDATE buku SET cover = '$cover', id_buku = '$idBuku', kategori = '$kategoriBuku', judul = '$judulBuku', pengarang = '$pengarangBuku', penerbit = '$penerbitBuku', tahun_terbit = '$tahunTerbit', jumlah_halaman = $jumlahHalaman, buku_deskripsi = '$deskripsiBuku' WHERE id_buku = '$idBuku'";
  mysqli_query($connection, $q);
  return mysqli_affected_rows($connection);
}

function deleteBuku($bukuId)
{
  global $connection;
  $bukuId = mysqli_real_escape_string($connection, $bukuId);
  mysqli_query($connection, "DELETE FROM peminjaman WHERE id_buku = '$bukuId'");
  mysqli_query($connection, "DELETE FROM buku WHERE id_buku = '$bukuId'");
  return mysqli_affected_rows($connection);
}

function searchBuku($keyword)
{
  $keyword = addslashes($keyword);
  $querySearch = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR penerbit LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
  return queryReadData($querySearch);
}

/**
 * Cari buku berdasarkan: judul, pengarang, atau penerbit.
 * $tipe: 'judul' | 'pengarang' | 'penerbit' | 'semua'
 */
function searchBukuBy($keyword, $tipe = 'semua')
{
  global $connection;
  if (trim($keyword) === '') return queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
  $k = mysqli_real_escape_string($connection, trim($keyword));
  $like = "'%" . $k . "%'";
  if ($tipe === 'judul') {
    $q = "SELECT * FROM buku WHERE judul LIKE $like ORDER BY id_buku DESC";
  } elseif ($tipe === 'pengarang') {
    $q = "SELECT * FROM buku WHERE pengarang LIKE $like ORDER BY id_buku DESC";
  } elseif ($tipe === 'penerbit') {
    $q = "SELECT * FROM buku WHERE penerbit LIKE $like ORDER BY id_buku DESC";
  } else {
    $q = "SELECT * FROM buku WHERE judul LIKE $like OR pengarang LIKE $like OR penerbit LIKE $like ORDER BY id_buku DESC";
  }
  return queryReadData($q);
}
