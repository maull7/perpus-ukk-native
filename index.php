<?php
require "config/config.php";
require "config/functions.php";
$buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
$kategori = queryReadData("SELECT * FROM kategori_buku ORDER BY kategori ASC");
foreach ($kategori as $kt) {
    if (isset($_POST[$kt['kategori']])) $buku = queryReadData("SELECT * FROM buku WHERE kategori = '" . $kt['kategori'] . "'");
}
if (isset($_POST["search"])) $buku = searchBuku($_POST["keyword"]);
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
                <button type="button" onclick="toggleMenu()">MENU</button>
                <div class="dropdown-plain" id="menuDropdown">
                    <a href="sign/index.php">Masuk</a>
                    <a href="sign/member/register.php">Daftar Member</a>
                </div>
            </div>
        </nav>
    </header>

    <section class="section-wrap">
        <h1 class="section-title">DAFTAR BUKU PERPUSTAKAAN</h1>

        <form action="" method="post" class="search-wrap">
            <input type="text" name="keyword" placeholder="Cari buku...">
            <button type="submit" name="search">Cari</button>
        </form>

        <form action="" method="post">
            <div class="kategori-wrap">
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

        <footer class="page-footer">
            <p>Copyright © 2026 UKK SMK MADYA.</p>
        </footer>
    </section>

    <script>
        function toggleMenu() {
            document.getElementById('menuDropdown').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) {
                document.getElementById('menuDropdown').classList.remove('show');
            }
        });
    </script>
</body>

</html>