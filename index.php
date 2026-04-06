<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require "config/config.php";
require "config/functions.php";
$buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
$kategori = queryReadData("SELECT * FROM kategori_buku ORDER BY kategori ASC");
foreach ($kategori as $kt) {
    if (isset($_POST[$kt['kategori']])) $buku = queryReadData("SELECT * FROM buku WHERE kategori = '" . $kt['kategori'] . "'");
}
if (isset($_POST["search"])) $buku = searchBuku($_POST["keyword"]);

$loginRedirect = function () {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            header('Location: DashboardAdmin/dashboardAdmin.php');
            exit;
        }
        if ($_SESSION['role'] === 'petugas') {
            header('Location: petugas/index.php');
            exit;
        }
    }
    if (isset($_SESSION['signIn']) && isset($_SESSION['member'])) {
        header('Location: DashboardMember/dashboardMember.php');
        exit;
    }
};
$loginRedirect();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aksara Perpus - Perpustakaan</title>
    <link rel="icon" href="assets/memberLogo.png" type="image/png">
    <link rel="stylesheet" href="assets/base.css">
</head>

<body>
    <header>
        <nav class="nav-plain">
            <span><strong>Madta Perpus</strong> <img src="assets/header.png" alt="Logo"></span>
            <div class="dropdown-wrap">
                <button type="button" onclick="toggleMenu()" aria-expanded="false" id="menuBtn">Menu</button>
                <div class="dropdown-plain" id="menuDropdown">
                    <a href="sign/index.php">Masuk</a>
                    <a href="sign/member/register.php">Daftar Member</a>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero" aria-label="Pengantar">
        <div class="hero-inner">
            <p class="hero-kicker">Perpustakaan digital</p>
            <h1 class="hero-title">Aksara Perpus</h1>
            <p class="hero-lead">Cari judul, pilih kategori, dan temukan buku yang ingin kamu baca.</p>
        </div>
    </section>

    <section class="section-wrap main-content">
        <h2 class="section-title">Katalog buku</h2>

        <form action="" method="post" class="search-wrap">
            <input type="text" name="keyword" placeholder="Cari judul atau kata kunci…" autocomplete="off">
            <button type="submit" name="search" class="btn btn-primary">Cari</button>
        </form>

        <form action="" method="post">
            <div class="kategori-wrap chip-row">
                <button type="submit">Semua</button>
                <?php foreach ($kategori as $kt) : ?>
                    <button type="submit" name="<?= strtolower($kt['kategori']) ?>"><?= htmlspecialchars($kt['kategori']) ?></button>
                <?php endforeach; ?>
            </div>
        </form>

        <div class="container-plain">
            <div class="card-grid">
                <?php foreach ($buku as $item) : ?>
                    <div class="card-item">
                        <a href="sign/index.php">
                            <img src="imgDB/<?= htmlspecialchars($item["cover"]); ?>" alt="cover">
                        </a>
                        <div class="body">
                            <strong><?= htmlspecialchars($item["judul"]); ?></strong>
                        </div>
                        <p class="meta">Kategori: <?= htmlspecialchars($item["kategori"]); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="page-footer">
        <p>Copyright © 2026 UKK SMK MADYA.</p>
    </footer>

    <script>
        function toggleMenu() {
            var d = document.getElementById('menuDropdown');
            var b = document.getElementById('menuBtn');
            d.classList.toggle('show');
            b.setAttribute('aria-expanded', d.classList.contains('show'));
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) {
                document.getElementById('menuDropdown').classList.remove('show');
                var b = document.getElementById('menuBtn');
                if (b) b.setAttribute('aria-expanded', 'false');
            }
        });
    </script>
</body>

</html>