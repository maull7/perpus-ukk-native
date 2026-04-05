<?php

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
