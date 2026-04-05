<?php
session_start();
if (!isset($_SESSION["signIn"]) || !isset($_SESSION["member"])) {
    header("Location: ../../sign/index.php");
    exit;
}
if (isset($_SESSION["role"])) {
    header("Location: " . ($_SESSION["role"] === "admin" ? "../../DashboardAdmin/dashboardAdmin.php" : "../../petugas/index.php"));
    exit;
}
require "../../config/config.php";
require "../../config/peminjaman.php";
$idBuku = $_GET["id"] ?? '';
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
$nisnSiswa = $_SESSION["member"]["nisn"];
$dataSiswa = queryReadData("SELECT * FROM member WHERE nisn = $nisnSiswa");
$admin = queryReadData("SELECT * FROM admin WHERE sebagai = 'petugas'");
if (isset($_POST["pinjam"])) {
    $idBaru = pinjamBuku($_POST);
    if ($idBaru > 0) {
        header("Location: upload_bukti.php?id=" . $idBaru . "&pesan=1");
        exit;
    }
    echo "<script>alert('Gagal diajukan!');</script>";
}
$item = $query[0] ?? null;
if (!$item) {
    header("Location: ../dashboardMember.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pinjam Buku - Member</title>
    <link rel="stylesheet" href="../../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="TransaksiPeminjaman.php">Peminjaman</a>
                <a href="TransaksiPengembalian.php">History</a>
                <a href="../dashboardMember.php">Dashboard</a>
                <a href="../signOut.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Form Pinjam Buku</h1>
        <div class="card-plain">
            <form action="" method="post">
                <input type="hidden" name="id_buku" value="<?= htmlspecialchars($item["id_buku"]); ?>">
                <input type="hidden" name="nisn" value="<?= $_SESSION["member"]["nisn"]; ?>">
                <div class="form-group"><label>Buku</label><input type="text" value="<?= htmlspecialchars($item["judul"]); ?>" readonly></div>
                <div class="form-group"><label>Petugas</label><select name="nama_admin" id="nama_admin" required>
                        <option value="">Pilih petugas</option><?php foreach ($admin as $a) : ?><option value="<?= htmlspecialchars($a["nama_admin"]); ?>" data-tlp="<?= htmlspecialchars($a["no_tlp"]); ?>"><?= htmlspecialchars($a["nama_admin"]); ?></option><?php endforeach; ?>
                    </select></div>
                <div class="form-group"><label>No Telp Petugas</label><input type="text" id="no_tlp" readonly></div>
                <div class="form-group"><label>Paket</label><select name="paket" id="paket">
                        <option value="">Non Paket</option>
                        <option value="1">Paket 1 (5 hari)</option>
                        <option value="2">Paket 2 (7 hari)</option>
                        <option value="3">Paket 3 (10 hari)</option>
                    </select></div>
                <div class="form-group"><label>Tanggal Pinjam</label><input type="date" name="tgl_peminjaman" id="tgl_peminjaman" required></div>
                <div class="form-group"><label>Tenggat Pengembalian</label><input type="date" name="tgl_pengembalian" id="tgl_pengembalian" required></div>
                <div class="form-group"><label>Harga</label><input type="number" name="harga" id="harga" required></div>
                <button type="submit" name="pinjam" class="btn btn-success">Ajukan Pinjam</button>
                <a href="../dashboardMember.php" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        document.getElementById('nama_admin').onchange = function() {
            var o = this.options[this.selectedIndex];
            document.getElementById('no_tlp').value = o.dataset.tlp || '';
        };

        function setReturnDate() {
            var p = document.getElementById('paket').value;
            var d = [1, 5, 7, 10];
            var add = d[p] || 1;
            var t = new Date();
            document.getElementById('tgl_peminjaman').value = t.toISOString().slice(0, 10);
            var r = new Date(t);
            r.setDate(r.getDate() + add);
            document.getElementById('tgl_pengembalian').value = r.toISOString().slice(0, 10);
            setPrice();
        }

        function setPrice() {
            var t1 = document.getElementById('tgl_peminjaman').value,
                t2 = document.getElementById('tgl_pengembalian').value;
            if (!t1 || !t2) {
                document.getElementById('harga').value = '';
                return;
            }
            var d = (new Date(t2) - new Date(t1)) / (86400 * 1000);
            var pr = document.getElementById('paket').value ? ([0, 1000, 900, 800][document.getElementById('paket').value] || 1250) : 1250;
            document.getElementById('harga').value = Math.max(0, Math.ceil(d)) * pr;
        }
        document.getElementById('paket').onchange = setReturnDate;
        document.getElementById('tgl_peminjaman').onchange = setPrice;
        document.getElementById('tgl_pengembalian').onchange = setPrice;
        setReturnDate();
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) document.getElementById('menuDropdown').classList.remove('show');
        });
    </script>
</body>

</html>