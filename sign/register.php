    <?php
    require_once __DIR__ . '/../loginSystem/connect.php';
    function getNextKodeMember()
    {
        global $connection;
        $q = mysqli_query(
            $connection,
            "SELECT kode_member 
            FROM member 
            ORDER BY CAST(SUBSTRING(kode_member, 4) AS UNSIGNED) DESC 
            LIMIT 1"
        );
        $r = ($q && mysqli_num_rows($q)) ? mysqli_fetch_assoc($q) : null;
        $last = $r ? $r['kode_member'] : null;
        if (!$last) return 'mem01';
        $number = (int) substr($last, 3) + 1;
        return 'mem' . str_pad($number, 2, '0', STR_PAD_LEFT);
    }


    $jurusanList = ['Desain Gambar Mesin', 'Teknik Pemesinan', 'Teknik Otomotif', 'Desain Pemodelan Informasi Bangunan', 'Teknik Konstruksi Perumahan', 'Teknik Tenaga Listrik', 'Teknik Instalasi Tenaga Listrik', 'Teknik Komputer Jaringan', 'Sistem Informatika Jaringan dan Aplikasi', 'Rekayasa Perangkat Lunak', 'Desain Komunikasi Visual'];
    $nextMemberCode = getNextKodeMember();
    $success = false;
    $errorMsg = '';

    if (isset($_POST['signUp'])) {
        $_POST['kode_member'] = $nextMemberCode;
        $_POST['tgl_pendaftaran'] = $_POST['tgl_pendaftaran'] ?? date('Y-m-d');
        $n = signUp($_POST);
        if ($n > 0) {
            header('Location: index.php?registered=1');
            exit;
        }
        $errorMsg = 'Pendaftaran gagal. Cek NISN, kode member, atau password.';
    }
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar Member - Perpustakaan</title>
        <link rel="stylesheet" href="../assets/base.css">
    </head>

    <body>
        <nav class="nav-plain">
            <a href="../index.php">Beranda</a>
            <a href="index.php">Masuk</a>
        </nav>
        <div class="container-plain">
            <h1 style="text-align:center;">Daftar Member</h1>
            <?php if ($errorMsg) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorMsg); ?></div>
            <?php endif; ?>
            <div class="card-plain">
                <form action="" method="post">
                    <div class="form-group"><label>NISN</label><input type="number" name="nisn" required></div>
                    <div class="form-group"><label>Kode Member</label><input type="text" name="kode_member" value="<?= htmlspecialchars($nextMemberCode); ?>" readonly></div>
                    <div class="form-group"><label>Nama</label><input type="text" name="nama" required></div>
                    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                    <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="confirmPw" required></div>
                    <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin">
                            <option value="">Pilih</option>
                            <option value="Laki laki">Laki laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select></div>
                    <div class="form-group"><label>Kelas</label><select name="kelas">
                            <option value="">Pilih</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                            <option value="XIII">XIII</option>
                        </select></div>
                    <div class="form-group"><label>Jurusan</label><select name="jurusan">
                            <option value="">Pilih</option><?php foreach ($jurusanList as $j) echo '<option value="' . htmlspecialchars($j) . '">' . htmlspecialchars($j) . '</option>'; ?>
                        </select></div>
                    <div class="form-group"><label>No Telepon</label><input type="text" name="no_tlp" required></div>
                    <div class="form-group"><label>Tanggal Pendaftaran</label><input type="date" name="tgl_pendaftaran" value="<?= date('Y-m-d'); ?>"></div>
                    <p>
                        <button type="submit" name="signUp" class="btn btn-primary">Daftar</button>
                        <a href="index.php" class="btn">Batal</a>
                    </p>
                    <p>Sudah punya akun? <a href="index.php">Masuk</a></p>
                </form>
            </div>
        </div>
    </body>

    </html>