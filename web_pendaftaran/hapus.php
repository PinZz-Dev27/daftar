<?php
require_once 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: data.php");
    exit;
}

// Proses Hapus Data
if (isset($_POST['konfirmasi_hapus'])) {
    $stmt = $conn->prepare("DELETE FROM `sija2` WHERE `NO` = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: data.php?pesan=hapus_berhasil");
        exit;
    } else {
        $stmt->close();
        header("Location: data.php?pesan=hapus_gagal");
        exit;
    }
}

// Ambil info data yang akan dihapus
$stmt = $conn->prepare("SELECT * FROM `sija2` WHERE `NO` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: data.php");
    exit;
}

$game = parseGameComment($data['COMMENT']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Data | SIJA GameDev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=2.1">
</head>
<body>

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
                <li><a href="data.php" class="nav-link">&larr; Kembali ke Data Peserta</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 50px;">
        <div style="max-width: 550px; margin: 0 auto;">
            <div class="card" style="border-color: var(--red-hover);">
                <div class="card-header" style="background: rgba(185, 28, 28, 0.15);">
                    <h2 class="card-title" style="color: var(--red-hover);">&#9888;&#65039; KONFIRMASI HAPUS</h2>
                </div>
                <div class="card-body" style="text-align: center;">
                    <p style="font-family: var(--font-pixel); font-size: 0.75rem; color: #ffffff; margin-bottom: 20px; line-height: 1.6;">
                        HAPUS DATA SISWA DARI DATABASE DATADEPIN?
                    </p>

                    <div style="background: var(--bg-input); padding: 18px; text-align: left; margin-bottom: 25px; border: 2px solid var(--border-pixel); line-height: 1.6; font-family: var(--font-mono); font-size: 1.2rem;">
                        <p><strong>ID Registrasi:</strong> <span style="color: var(--red-hover);">SIJA-<?= str_pad($data['NO'], 4, '0', STR_PAD_LEFT) ?></span></p>
                        <p><strong>Nama Siswa:</strong> <?= htmlspecialchars($data['NAMA']) ?></p>
                        <p><strong>Kelas:</strong> <?= htmlspecialchars($game['kelas']) ?></p>
                        <p><strong>Judul Game:</strong> <?= htmlspecialchars($game['judul_game']) ?></p>
                        <p><strong>Engine:</strong> <?= htmlspecialchars($game['engine']) ?></p>
                    </div>

                    <form action="hapus.php?id=<?= $id ?>" method="POST" style="display: flex; gap: 12px; justify-content: center;">
                        <input type="hidden" name="konfirmasi_hapus" value="1">
                        <button type="submit" class="btn btn-danger" style="flex: 1;">
                            &#128465; [ YA, HAPUS ]
                        </button>
                        <a href="data.php" class="btn btn-secondary" style="flex: 1;">
                            Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
