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
    die("<div style='font-family:sans-serif; text-align:center; padding:50px; color:#fff; background:#0b0f19;'>
        <h2>Data Siswa Tidak Ditemukan di Database!</h2>
        <p>Data dengan ID tersebut tidak ada di tabel <code>sija2</code>.</p>
        <br><a href='data.php' style='color:#06b6d4;'>&larr; Kembali ke Daftar Peserta</a>
    </div>");
}

$game = parseGameComment($data['COMMENT']);
$regCode = "SIJA-GAME-" . str_pad($data['NO'], 4, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta: <?= htmlspecialchars($data['NAMA']) ?> | SIJA GameDev</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .ticket-code {
            font-family: monospace;
            background: #000;
            color: #06b6d4;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 1.15rem;
            letter-spacing: 2px;
            display: inline-block;
            border: 1px solid #06b6d4;
        }
        .action-bar {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin: 25px 0 40px 0;
            flex-wrap: wrap;
        }
        @media print {
            .action-bar, .navbar, .footer, .alert {
                display: none !important;
            }
        }
    </style>
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
                <li><a href="index.php" class="nav-link nav-link-cta">+ Daftar Baru</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 20px;">
        
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'terdaftar'): ?>
            <div class="alert alert-success">
                <span>
                    <strong>Pendaftaran Berhasil!</strong> Data kamu telah resmi tersimpan di database <em>datadepin</em> pada tabel <em>sija2</em>. Simpan atau cetak kartu bukti pendaftaran lomba di bawah ini.
                </span>
            </div>
        <?php endif; ?>

        <!-- Kartu Tanda Peserta Resmi -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div>
                    <h2 style="font-size: 1.35rem; color: #fff; margin-bottom: 4px;">KARTU BUKTI PENDAFTARAN LOMBA</h2>
                    <p style="color: var(--text-muted); font-size: 0.85rem;">SIJA Game Developer Competition &bull; Database: datadepin</p>
                </div>
                <div>
                    <span class="ticket-code"><?= $regCode ?></span>
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <div class="profile-item-label">Nama Lengkap Siswa</div>
                    <div class="profile-item-value"><?= htmlspecialchars($data['NAMA']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Kelas Siswa SIJA</div>
                    <div class="profile-item-value"><span class="badge badge-info"><?= htmlspecialchars($game['kelas']) ?></span></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Jenis Kelamin</div>
                    <div class="profile-item-value"><?= htmlspecialchars($data['GENDER']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Email Siswa</div>
                    <div class="profile-item-value"><?= htmlspecialchars($data['EMAIL']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Judul Game</div>
                    <div class="profile-item-value" style="color: var(--cyan);">&#127918; <?= htmlspecialchars($game['judul_game']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Genre / Kategori Game</div>
                    <div class="profile-item-value"><?= htmlspecialchars($game['genre']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Game Engine</div>
                    <div class="profile-item-value">&#9881;&#65039; <?= htmlspecialchars($game['engine']) ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-item-label">Target Platform</div>
                    <div class="profile-item-value">&#128187; <?= htmlspecialchars($game['platform']) ?></div>
                </div>

                <?php if (!empty($data['WEBSITE'])): ?>
                <div class="profile-item" style="grid-column: 1 / -1;">
                    <div class="profile-item-label">Link Demo / Web / Repositori Proyek</div>
                    <div class="profile-item-value">
                        <a href="<?= htmlspecialchars($data['WEBSITE']) ?>" target="_blank" rel="noopener noreferrer">
                            <?= htmlspecialchars($data['WEBSITE']) ?> &#8599;
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <div class="profile-item" style="grid-column: 1 / -1;">
                    <div class="profile-item-label">Sinopsis & Deskripsi Gameplay Game</div>
                    <div class="profile-item-value" style="font-size: 0.95rem; font-weight: normal; line-height: 1.6; white-space: pre-wrap;"><?= htmlspecialchars($game['deskripsi']) ?></div>
                </div>
            </div>

            <div style="padding: 16px 30px; background: rgba(0,0,0,0.25); border-top: 1px solid var(--border-color); font-size: 0.8rem; color: var(--text-dim); text-align: center;">
                Tunjukkan bukti pendaftaran ini saat sesi technical meeting dan presentasi game di Laboratorium SIJA.
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="action-bar">
            <button onclick="window.print()" class="btn btn-primary">
                &#128438;&#65039; Cetak / Download PDF
            </button>
            <a href="edit.php?id=<?= $data['NO'] ?>" class="btn btn-warning">
                &#9998;&#65039; Edit Data
            </a>
            <a href="hapus.php?id=<?= $data['NO'] ?>" class="btn btn-danger">
                &#128465; Hapus Data
            </a>
            <a href="data.php" class="btn btn-secondary">
                &#128203; Lihat Semua Data
            </a>
            <a href="index.php" class="btn btn-secondary">
                &#43; Daftar Siswa Baru
            </a>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <strong>SIJA GameDev Arena</strong> - Pendaftaran Lomba Game Siswa SIJA</p>
            <p style="font-size: 0.78rem; margin-top: 5px;">Database: <code>datadepin</code> &bull; Tabel: <code>sija2</code></p>
        </div>
    </footer>

</body>
</html>
