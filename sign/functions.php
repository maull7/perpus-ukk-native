<?php
function loginMember($nama, $password)
{
    global $connection;
    $nama = mysqli_real_escape_string($connection, strtolower(trim($nama)));
    $result = mysqli_query($connection, "SELECT * FROM member WHERE nama = '$nama'");
    if (!$result || mysqli_num_rows($result) !== 1) return null;
    $row = mysqli_fetch_assoc($result);
    if (!password_verify($password, $row['password'])) return null;
    return ['nisn' => $row['nisn'], 'nama' => $row['nama']];
}

function loginAdmin($nama, $password)
{
    global $connection;
    $nama = mysqli_real_escape_string($connection, trim($nama));
    $result = mysqli_query($connection, "SELECT * FROM admin WHERE nama_admin = '$nama' AND sebagai = 'admin'");
    if (!$result || mysqli_num_rows($result) !== 1) return null;
    $row = mysqli_fetch_assoc($result);
    if ($row['password'] !== $password) return null;
    return ['id' => $row['id'], 'nama_admin' => $row['nama_admin']];
}

function loginPetugas($nama, $password)
{
    global $connection;
    $nama = mysqli_real_escape_string($connection, trim($nama));
    $result = mysqli_query($connection, "SELECT * FROM admin WHERE nama_admin = '$nama' AND sebagai = 'petugas'");
    if (!$result || mysqli_num_rows($result) !== 1) return null;
    $row = mysqli_fetch_assoc($result);
    if ($row['password'] !== $password) return null;
    return ['id' => $row['id'], 'nama_admin' => $row['nama_admin']];
}
