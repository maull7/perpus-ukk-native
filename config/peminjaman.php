<?php

/**
 * Fungsi transaksi peminjaman. Pakai: require config dulu, lalu require file ini.
 */
if (!isset($connection)) {
  require_once __DIR__ . '/config.php';
}

function pinjamBuku($dataBuku)
{
  global $connection;
  $idBuku = mysqli_real_escape_string($connection, $dataBuku["id_buku"]);
  $nisn = (int) $dataBuku["nisn"];
  $idAdmin = mysqli_real_escape_string($connection, $dataBuku["nama_admin"]);
  $tglPinjam = mysqli_real_escape_string($connection, $dataBuku["tgl_peminjaman"]);
  $tglKembali = mysqli_real_escape_string($connection, $dataBuku["tgl_pengembalian"]);
  $harga = (int) $dataBuku["harga"];
  $cek = mysqli_query($connection, "SELECT * FROM peminjaman WHERE id_buku = '$idBuku' AND nisn = $nisn AND (status = 'Belum konfirmasi' OR status = 'Konfirmasi')");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Anda sudah meminjam buku ini');</script>";
    return 0;
  }
  $q = "INSERT INTO peminjaman (id_buku, nisn, nama_admin, tgl_peminjaman, tgl_pengembalian, status, harga, bukti_transaksi) VALUES ('$idBuku', $nisn, '$idAdmin', '$tglPinjam', '$tglKembali', 'Belum konfirmasi', $harga, '')";
  if (mysqli_query($connection, $q)) return (int) mysqli_insert_id($connection);
  echo "Error: " . mysqli_error($connection);
  return 0;
}

function tolakPeminjaman($idPeminjaman)
{
  global $connection;
  $id = (int) $idPeminjaman;
  mysqli_query($connection, "UPDATE peminjaman SET status = 'Ditolak' WHERE id_peminjaman = $id");
  return mysqli_affected_rows($connection);
}

function pengembalian()
{
  global $connection;
  $waktuSekarang = date("Y-m-d H:i:s");
  $result = mysqli_query($connection, "SELECT * FROM peminjaman WHERE tgl_pengembalian < '$waktuSekarang'");
  while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_peminjaman'];
    mysqli_query($connection, "UPDATE peminjaman SET status = 'Waktu habis' WHERE id_peminjaman = '$id'");
  }
}
