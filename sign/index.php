<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';

$loginRedirect = function () {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            header('Location: ../DashboardAdmin/dashboardAdmin.php');
            exit;
        }
        if ($_SESSION['role'] === 'petugas') {
            header('Location: ../petugas/index.php');
            exit;
        }
    }
    if (isset($_SESSION['signIn']) && isset($_SESSION['member'])) {
        header('Location: ../DashboardMember/dashboardMember.php');
        exit;
    }
};

$loginRedirect();

$error = false;
$logoutMsg = '';
if (isset($_GET['logout'])) {
    $logoutMsg = 'Anda berhasil logout.';
}
if (isset($_GET['registered'])) {
    $logoutMsg = 'Pendaftaran berhasil. Silakan masuk.';
}

if (isset($_POST['signIn'])) {
    $role = $_POST['role'] ?? '';
    $nama = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($role === 'member') {
        $user = loginMember($nama, $password);
        if ($user) {
            $_SESSION['signIn'] = true;
            $_SESSION['member'] = ['nisn' => $user['nisn'], 'nama' => $user['nama']];
            header('Location: ../DashboardMember/dashboardMember.php');
            exit;
        }
    } elseif ($role === 'admin') {
        $user = loginAdmin($nama, $password);
        if ($user) {
            $_SESSION['signIn'] = true;
            $_SESSION['role'] = 'admin';
            $_SESSION['nama_admin'] = $user['nama_admin'];
            $_SESSION['admin_id'] = $user['id'];
            header('Location: ../DashboardAdmin/dashboardAdmin.php');
            exit;
        }
    } elseif ($role === 'petugas') {
        $user = loginPetugas($nama, $password);
        if ($user) {
            $_SESSION['signIn'] = true;
            $_SESSION['role'] = 'petugas';
            $_SESSION['nama_admin'] = $user['nama_admin'];
            $_SESSION['admin_id'] = $user['id'];
            header('Location: ../petugas/index.php');
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Perpustakaan</title>
    <link rel="stylesheet" href="../assets/base.css">
</head>

<body class="auth-page">
    <nav class="nav-plain">
        <a href="../index.php">Beranda</a>
        <a href="register.php">Daftar Member</a>
    </nav>
    <div class="container-plain auth-wrap">
        <h1 class="auth-heading">Masuk</h1>
        <?php if ($logoutMsg) : ?>
            <div class="alert alert-success"><?= htmlspecialchars($logoutMsg); ?></div>
        <?php endif; ?>
        <div class="card-plain">
            <h2 style="margin-top:0;text-align:center;">Login</h2>
            <form action="" method="post">
                <?php if ($error) : ?>
                    <div class="alert alert-danger">Nama atau password salah.</div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Masuk sebagai</label>
                    <select name="role" required>
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required autocomplete="current-password">
                </div>
                <p>
                    <button type="submit" name="signIn" class="btn btn-primary">Masuk</button>
                    <a href="../index.php" class="btn">Batal</a>
                </p>
                <p>Belum punya akun? <a href="register.php">Daftar Member</a></p>
            </form>
        </div>
    </div>
</body>

</html>