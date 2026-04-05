<?php

/**
 * Koneksi database & fungsi baca data umum.
 */
$host = "localhost";
$username = "root";
$password = "";
$database_name = "perpustakaan";
$connection = mysqli_connect($host, $username, $password, $database_name);

function queryReadData($query)
{
  global $connection;
  $result = mysqli_query($connection, $query);
  $items = [];
  while ($item = mysqli_fetch_assoc($result)) {
    $items[] = $item;
  }
  return $items;
}
