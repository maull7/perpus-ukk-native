<?php
require_once "../config/config.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");
$query = mysqli_query($conn, "SELECT * FROM admin ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($query);
$lastAdminNumber = $data ? intval(substr($data['kode_admin'], 5)) : 0;
$queryPetugas = mysqli_query($conn, "SELECT * FROM admin WHERE sebagai = 'petugas' ORDER BY id DESC LIMIT 1");
$dataPetugas = mysqli_fetch_assoc($queryPetugas);
$lastPetugasNumber = $dataPetugas ? intval(substr($dataPetugas['kode_admin'], 7)) : 0;
if ($lastAdminNumber == 0) $lastAdminNumber = 1;
if ($lastPetugasNumber == 0) $lastPetugasNumber = 1;
$admin = queryReadData("SELECT * FROM admin");

if (isset($_POST["signup"])) {
    $nama_admin = $_POST['nama_admin'];
    $password = $_POST['password'];
    $kode_admin = $_POST['kode_admin'];
    $no_tlp = $_POST['no_tlp'];
    $sebagai = $_POST['sebagai'];
    if ($sebagai === "admin") {
        $lastAdminNumber++;
        $kode_admin = "admin" . $lastAdminNumber;
    } elseif ($sebagai === "petugas") {
        $lastPetugasNumber++;
        $kode_admin = "petugas" . $lastPetugasNumber;
    }
    $sql = "INSERT INTO admin (nama_admin, password, kode_admin, no_tlp, sebagai) VALUES ('$nama_admin', '$password', '$kode_admin', '$no_tlp','$sebagai')";
    if (mysqli_query($connection, $sql)) {
        header("Location: petugas.php?status=success");
        exit;
    }
    header("Location: petugas.php?status=error");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petugas - Perpustakaan</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body>
    <nav class="nav-plain">
        <span><strong>Madya Perpus</strong> <img src="../assets/header.png" alt="Logo" style="width:36px;height:36px;vertical-align:middle;border-radius:50%;"></span>
        <div class="dropdown-wrap">
            <button type="button" onclick="document.getElementById('menuDropdown').classList.toggle('show')">Menu</button>
            <div class="dropdown-plain" id="menuDropdown">
                <a href="kategori/index.php">Kategori Buku</a>
                <a href="konfirmasi_peminjaman.php">Konfirmasi Peminjaman</a>
                <a href="laporan/index.php">Laporan</a>
                <a href="member/member.php">Member</a>
                <a href="buku/tambahBuku.php">Tambah Buku</a>
                <a href="petugas.php">Petugas</a>
                <a href="dashboardAdmin.php">Dashboard</a>
            </div>
        </div>
    </nav>
    <div class="container-plain">
        <h1 class="section-title">Daftar Akun Pengguna</h1>
        <?php if (isset($_GET['status'])) : ?>
            <div class="alert <?= $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger'; ?>"><?= $_GET['status'] === 'success' ? 'Berhasil.' : 'Gagal.'; ?></div>
        <?php endif; ?>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Password</th>
                        <th>Kode</th>
                        <th>No Tlp</th>
                        <th>Sebagai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin as $d) : ?>
                        <tr>
                            <td><?= $d["id"]; ?></td>
                            <td><?= $d["nama_admin"]; ?></td>
                            <td><?= $d["password"]; ?></td>
                            <td><?= $d["kode_admin"]; ?></td>
                            <td><?= $d["no_tlp"]; ?></td>
                            <td><?= $d["sebagai"]; ?></td>
                            <td><a href="deletepetugas.php?id=<?= $d["id"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?');">Hapus</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-plain" style="margin-top:20px;">
            <h2 style="margin-top:0;">Tambah Petugas</h2>
            <form action="" method="post">
                <div class="form-group"><label>Nama</label><input type="text" name="nama_admin" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                <div class="form-group"><label>Sebagai</label><select name="sebagai">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select></div>
                <div class="form-group"><label>Kode (otomatis)</label><input type="text" name="kode_admin" id="kode_admin" value="" readonly></div>
                <div class="form-group"><label>No Telepon</label><input type="text" name="no_tlp" required></div>
                <button type="submit" name="signup" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
    <footer class="page-footer">Copyright © 2026 UKK SMK MADYA.</footer>
    <script>
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-wrap')) document.getElementById('menuDropdown').classList.remove('show');
        });
    </script>
    <script>
        var lastAdmin = <?= $lastAdminNumber; ?>,
            lastPetugas = <?= $lastPetugasNumber; ?>;
        document.querySelector('select[name=sebagai]').onchange = function() {
            if (this.value === 'admin') {
                lastAdmin++;
                document.getElementById('kode_admin').value = 'admin' + lastAdmin;
            } else {
                lastPetugas++;
                document.getElementById('kode_admin').value = 'petugas' + lastPetugas;
            }
        };
    </script>
</body>

</html>