<?php
require_once 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: data.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM `sija2` WHERE `NO` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("<div style='font-family:sans-serif; text-align:center; padding:50px; color:#fff; background:#0a0a0c;'>
        <h2>Data Tidak Ditemukan!</h2>
        <a href='data.php' style='color:#dc2626;'>&larr; Kembali ke Data Peserta</a>
    </div>");
}

$game = parseGameComment($data['COMMENT']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peserta: <?= htmlspecialchars($data['NAMA']) ?> | SIJA GameDev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=2.1">
</head>
<body>

    <!-- Navigasi -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo-brand">
                <div class="logo-badge">SIJA</div>
                <div class="logo-text">
                    <h1>GAMEDEV ARENA</h1>
                    <span>Kompetisi Game Siswa SIJA</span>
                </div>
            </a>
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Pendaftaran</a></li>
                <li><a href="data.php" class="nav-link">Data Peserta</a></li>
                <li><a href="detail.php?id=<?= $data['NO'] ?>" class="nav-link">Kartu Peserta</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 30px; padding-bottom: 50px;">
        
        <div style="max-width: 800px; margin: 0 auto;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-family: var(--font-pixel); font-size: 1.15rem; color: #fff;">&#9998;&#65039; EDIT DATA PESERTA</h1>
                <a href="data.php" class="btn btn-secondary btn-sm">&larr; Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="card-title">Edit: <?= htmlspecialchars($data['NAMA']) ?></span>
                    <span class="badge badge-info">ID: #<?= str_pad($data['NO'], 4, '0', STR_PAD_LEFT) ?></span>
                </div>

                <div class="card-body">
                    <form action="proses_edit.php" method="POST">
                        <input type="hidden" name="no" value="<?= $data['NO'] ?>">

                        <!-- Identitas Siswa -->
                        <h3 style="color: var(--red-hover); font-family: var(--font-pixel); font-size: 0.74rem; letter-spacing: 0.5px; margin-bottom: 14px; border-bottom: 2px dashed var(--border-pixel); padding-bottom: 6px;">
                            [A] IDENTITAS SISWA SIJA
                        </h3>

                        <div class="form-row">
                            <div class="form-group" style="flex: 2;">
                                <label class="form-label">Nama Lengkap Siswa <span class="req">*</span></label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['NAMA']) ?>" required>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="Laki-laki" <?= (stripos($data['GENDER'], 'laki') !== false || strtolower($data['GENDER']) === 'pria' || strtolower($data['GENDER']) === 'male') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= (stripos($data['GENDER'], 'perempuan') !== false || stripos($data['GENDER'], 'wanita') !== false || strtolower($data['GENDER']) === 'female') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Kelas Siswa SIJA <span class="req">*</span></label>
                                <select name="kelas" class="form-control" required>
                                    <?php 
                                    $kelasList = [
                                        'X SIJA 1', 'X SIJA 2', 
                                        'XI SIJA 1', 'XI SIJA 2', 
                                        'XII SIJA 1', 'XII SIJA 2', 
                                        'XIII SIJA 1', 'XIII SIJA 2'
                                    ];
                                    foreach ($kelasList as $kls): ?>
                                        <option value="<?= $kls ?>" <?= ($game['kelas'] === $kls) ? 'selected' : '' ?>><?= $kls ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat Email Siswa <span class="req">*</span></label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['EMAIL']) ?>" required>
                            </div>
                        </div>

                        <!-- Data Game -->
                        <h3 style="color: var(--red-hover); font-family: var(--font-pixel); font-size: 0.74rem; letter-spacing: 0.5px; margin: 24px 0 14px 0; border-bottom: 2px dashed var(--border-pixel); padding-bottom: 6px;">
                            [B] DETAIL PROYEK GAME
                        </h3>

                        <div class="form-row">
                            <div class="form-group" style="flex: 2;">
                                <label class="form-label">Nama / Judul Game <span class="req">*</span></label>
                                <input type="text" name="judul_game" class="form-control" value="<?= htmlspecialchars($game['judul_game']) ?>" required>
                            </div>
                            <div class="form-group" style="flex: 1.5;">
                                <label class="form-label">Genre / Kategori <span class="req">*</span></label>
                                <select name="genre" class="form-control" required>
                                    <?php 
                                    $genreList = [
                                        '2D Platformer',
                                        'RPG (Role Playing Game)',
                                        '3D Action & Adventure',
                                        'Edukasi SIJA / IT',
                                        'Horror & Mystery',
                                        'Puzzle & Strategy',
                                        'Arcade & Casual'
                                    ];
                                    foreach ($genreList as $g): ?>
                                        <option value="<?= $g ?>" <?= ($game['genre'] === $g) ? 'selected' : '' ?>><?= $g ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Game Engine <span class="req">*</span></label>
                                <select name="engine" class="form-control" required>
                                    <?php 
                                    $engList = [
                                        'Godot Engine',
                                        'Unity',
                                        'Unreal Engine',
                                        'Construct 3',
                                        'RPG Maker',
                                        'GameMaker Studio',
                                        'Python / Pygame',
                                        'Web / Phaser.js',
                                        'Lainnya'
                                    ];
                                    foreach ($engList as $eng): ?>
                                        <option value="<?= $eng ?>" <?= ($game['engine'] === $eng) ? 'selected' : '' ?>><?= $eng ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Target Platform <span class="req">*</span></label>
                                <select name="platform" class="form-control" required>
                                    <option value="PC / Windows" <?= ($game['platform'] === 'PC / Windows') ? 'selected' : '' ?>>PC / Windows</option>
                                    <option value="Android / Mobile" <?= ($game['platform'] === 'Android / Mobile') ? 'selected' : '' ?>>Android / Mobile</option>
                                    <option value="Web Browser (HTML5)" <?= ($game['platform'] === 'Web Browser (HTML5)') ? 'selected' : '' ?>>Web Browser (HTML5)</option>
                                    <option value="Multi-platform" <?= ($game['platform'] === 'Multi-platform') ? 'selected' : '' ?>>Multi-platform</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Website / Link Demo / Repositori Proyek</label>
                            <input type="url" name="website" class="form-control" value="<?= htmlspecialchars($data['WEBSITE']) ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi & Sinopsis Game <span class="req">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($game['deskripsi']) ?></textarea>
                        </div>

                        <div style="margin-top: 25px; display: flex; gap: 12px;">
                            <button type="submit" name="update" class="btn btn-primary" style="flex: 2;">
                                &#128190; [ SIMPAN PERUBAHAN ]
                            </button>
                            <a href="data.php" class="btn btn-secondary" style="flex: 1;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <strong>SIJA GAMEDEV ARENA</strong> - Pendaftaran Lomba Game Siswa SIJA</p>
            <p style="font-size: 0.95rem; margin-top: 5px;">Database: <code>datadepin</code> &bull; Tabel: <code>sija2</code></p>
        </div>
    </footer>

</body>
</html>
