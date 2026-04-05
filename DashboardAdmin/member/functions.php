<?php
if (!function_exists('queryReadData')) {
  require_once __DIR__ . '/../../config/config.php';
}

function deleteMember($nisnMember)
{
  global $connection;
  $nisnMember = (int) $nisnMember;
  mysqli_query($connection, "DELETE FROM peminjaman WHERE nisn = $nisnMember");
  mysqli_query($connection, "DELETE FROM member WHERE nisn = $nisnMember");
  return mysqli_affected_rows($connection);
}

function searchMember($keyword)
{
  $keyword = addslashes($keyword);
  $q = "SELECT * FROM member WHERE nisn LIKE '%$keyword%' OR kode_member LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
  return queryReadData($q);
}
