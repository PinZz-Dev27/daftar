<?php
require_once 'koneksi.php';

// Ambil total pendaftar saat ini dari tabel sija2 database datadepin
$queryCount = "SELECT COUNT(*) as total FROM `sija2`";
$resCount = $conn->query($queryCount);
$totalPendaftar = 0;
if ($resCount) {
    $rowC = $resCount->fetch_assoc();
    $totalPendaftar = $rowC['total'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Lomba Game SIJA 2026 | GameDev Arena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=2.1">
</head>
<body>

    <!-- Navigasi Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo-brand">
                <div class="logo-badge">SIJA</div>
                <div class="logo-text">
                    <h1>GAMEDEV ARENA</h1>
                    <span>Kompetisi Pembuatan Game Siswa SIJA</span>
                </div>
            </a>
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link active">Pendaftaran</a></li>
                <li><a href="data.php" class="nav-link">Data Peserta (<?= $totalPendaftar ?>)</a></li>
                <li><a href="#aturan" class="nav-link">Panduan Lomba</a></li>
                <li><a href="data.php" class="nav-link nav-link-cta">Data Peserta</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section">
            <span class="hero-pill">&#127918; [ PRESS START ] SIJA GAMEDEV ARENA</span>
            <h1 class="hero-title">Lomba Game Siswa SIJA</h1>
            
            <!-- Tulisan Bergerak Mengetik (Typewriter Retro Terminal) -->
            <div class="typing-container">
                <span class="typing-tag">&gt;&gt;</span>
                <span class="typing-text" id="typewriter"></span><span class="typing-cursor">█</span>
                <noscript>
                    <span class="typewriter-css">REGISTRASI LOMBA GAME DEVELOPER SIJA 2026 TELAH DIBUKA!</span>
                </noscript>
            </div>

            <p class="hero-subtitle">
                Ajang adu kreasi, inovasi, dan coding siswa SIJA (Sistem Informatika Jaringan & Aplikasi) dalam merancang video game interaktif berkualitas!
            </p>

            <div class="hero-stats">
                <div class="hero-stat-item">
                    <span class="num"><?= $totalPendaftar ?></span>
                    <span class="label">Siswa Terdaftar</span>
                </div>
                <div class="hero-stat-item">
                    <span class="num">7+</span>
                    <span class="label">Genre & Kategori</span>
                </div>
                <div class="hero-stat-item">
                    <span class="num">100%</span>
                    <span class="label">Gratis Pendaftaran</span>
                </div>
                <div class="hero-stat-item">
                    <span class="num">PIALA</span>
                    <span class="label">Hadiah & Juara</span>
                </div>
            </div>
        </section>

        <!-- Notifikasi Pesan -->
        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] == 'gagal'): ?>
                <div class="alert alert-danger">
                    <strong>Peringatan!</strong> Pendaftaran gagal: <?= htmlspecialchars($_GET['error'] ?? 'Periksa kembali data Anda.') ?>
                </div>
            <?php elseif ($_GET['pesan'] == 'sukses'): ?>
                <div class="alert alert-success">
                    <strong>Berhasil!</strong> Data pendaftaran siswa telah tersimpan ke database <em>datadepin</em> pada tabel <em>sija2</em>.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Konten Formulir & Sidebar Info -->
        <div class="layout-grid">
            
            <!-- Form Input Pendaftaran -->
            <div class="form-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">&#128221; Formulir Pendaftaran Game Siswa</h2>
                        <span class="badge badge-info">Database: datadepin &bull; sija2</span>
                    </div>

                    <div class="card-body">
                        <form action="proses_tambah.php" method="POST" autocomplete="off">

                            <!-- Bagian 1: Identitas Siswa -->
                            <h3 style="color: var(--red-hover); font-family: var(--font-pixel); font-size: 0.76rem; letter-spacing: 0.5px; margin-bottom: 16px; border-bottom: 2px dashed var(--border-pixel); padding-bottom: 8px;">
                                [A] IDENTITAS SISWA SIJA
                            </h3>

                            <div class="form-row">
                                <div class="form-group" style="flex: 2;">
                                    <label class="form-label">Nama Lengkap Siswa <span class="req">*</span></label>
                                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Devin Hardiansyah" required>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Kelas Siswa SIJA <span class="req">*</span></label>
                                    <select name="kelas" class="form-control" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <optgroup label="Tingkat X (Kelas 10)">
                                            <option value="X SIJA 1">X SIJA 1</option>
                                            <option value="X SIJA 2">X SIJA 2</option>
                                        </optgroup>
                                        <optgroup label="Tingkat XI (Kelas 11)">
                                            <option value="XI SIJA 1">XI SIJA 1</option>
                                            <option value="XI SIJA 2">XI SIJA 2</option>
                                        </optgroup>
                                        <optgroup label="Tingkat XII (Kelas 12)">
                                            <option value="XII SIJA 1">XII SIJA 1</option>
                                            <option value="XII SIJA 2">XII SIJA 2</option>
                                        </optgroup>
                                        <optgroup label="Tingkat XIII (Kelas 13)">
                                            <option value="XIII SIJA 1">XIII SIJA 1</option>
                                            <option value="XIII SIJA 2">XIII SIJA 2</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat Email Aktif <span class="req">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="nama.siswa@gmail.com" required>
                                </div>
                            </div>

                            <!-- Bagian 2: Detail Game -->
                            <h3 style="color: var(--red-hover); font-family: var(--font-pixel); font-size: 0.76rem; letter-spacing: 0.5px; margin: 26px 0 16px 0; border-bottom: 2px dashed var(--border-pixel); padding-bottom: 8px;">
                                [B] DETAIL PROYEK GAME
                            </h3>

                            <div class="form-row">
                                <div class="form-group" style="flex: 2;">
                                    <label class="form-label">Nama / Judul Game <span class="req">*</span></label>
                                    <input type="text" name="judul_game" class="form-control" placeholder="Contoh: Cyber Network Defender" required>
                                </div>
                                <div class="form-group" style="flex: 1.5;">
                                    <label class="form-label">Genre / Kategori Game <span class="req">*</span></label>
                                    <select name="genre" class="form-control" required>
                                        <option value="">-- Pilih Genre --</option>
                                        <option value="2D Platformer">2D Platformer</option>
                                        <option value="RPG (Role Playing Game)">RPG (Role Playing Game)</option>
                                        <option value="3D Action & Adventure">3D Action & Adventure</option>
                                        <option value="Edukasi SIJA / IT">Edukasi SIJA / IT</option>
                                        <option value="Horror & Mystery">Horror & Mystery</option>
                                        <option value="Puzzle & Strategy">Puzzle & Strategy</option>
                                        <option value="Arcade & Casual">Arcade & Casual</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Game Engine <span class="req">*</span></label>
                                    <select name="engine" class="form-control" required>
                                        <option value="">-- Pilih Engine --</option>
                                        <option value="Godot Engine">Godot Engine (GDScript / C#)</option>
                                        <option value="Unity">Unity (C#)</option>
                                        <option value="Unreal Engine">Unreal Engine 5 (Blueprints / C++)</option>
                                        <option value="Construct 3">Construct 3 / 2</option>
                                        <option value="RPG Maker">RPG Maker</option>
                                        <option value="GameMaker Studio">GameMaker Studio</option>
                                        <option value="Python / Pygame">Python / Pygame</option>
                                        <option value="Web / Phaser.js">Web Canvas / Phaser.js</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Target Platform <span class="req">*</span></label>
                                    <select name="platform" class="form-control" required>
                                        <option value="PC / Windows">PC / Windows</option>
                                        <option value="Android / Mobile">Android / Mobile</option>
                                        <option value="Web Browser (HTML5)">Web Browser (HTML5)</option>
                                        <option value="Multi-platform">Multi-platform</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Website / Link Demo / Repositori Proyek (Opsional)</label>
                                <input type="url" name="website" class="form-control" placeholder="https://github.com/... atau https://gamekamu.netlify.app/ atau Google Drive">
                                <div class="form-text">Tersimpan di kolom <code>WEBSITE</code> pada tabel <code>sija2</code>.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Sinopsis & Deskripsi Gameplay <span class="req">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan alur cerita game, mekanisme permainan, dan tantangan yang ada dalam game..." required></textarea>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" id="persetujuan" name="persetujuan" required>
                                <label for="persetujuan">
                                    Saya menyatakan data yang diisi adalah benar, karya game adalah hasil karya orisinal siswa SIJA, dan siap mematuhi seluruh peraturan lomba.
                                </label>
                            </div>

                            <div style="margin-top: 25px;">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">
                                    &#128640; [ SUBMIT ] SIMPAN PENDAFTARAN GAME
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Informasi -->
            <div class="sidebar-wrapper" id="aturan">
                
                <div class="info-card">
                    <h3 class="info-title">&#128203; SYARAT & KETENTUAN</h3>
                    <ul class="info-list">
                        <li>Peserta adalah siswa aktif jurusan SIJA (Kelas X, XI, XII, atau XIII).</li>
                        <li>Dapat diikuti secara individu maupun perwakilan tim.</li>
                        <li>Game dapat bertema edukasi teknologi, aksi, strategi, atau petualangan.</li>
                        <li>Tidak mengandung unsur SARA, ujaran kebencian, atau konten negatif.</li>
                        <li>Free assets diperbolehkan dengan menyertakan kredit lisensi.</li>
                        <li>Finalis akan mempresentasikan build game di hadapan dewan juri SIJA.</li>
                    </ul>
                </div>

                <div class="info-card">
                    <h3 class="info-title">&#128337; JADWAL KEGIATAN</h3>
                    <ul class="info-list">
                        <li><strong>Pendaftaran Online:</strong> Dibuka Sekarang</li>
                        <li><strong>Technical Meeting:</strong> Info via Email Siswa</li>
                        <li><strong>Batas Pengumpulan File:</strong> H-5 Penjurian</li>
                        <li><strong>Showcase & Presentasi:</strong> Lab Jaringan SIJA</li>
                        <li><strong>Penyerahan Hadiah:</strong> Sesi Penutupan Acara</li>
                    </ul>
                </div>

                <div class="info-card">
                    <h3 class="info-title">&#128190; DATABASE MYSQL</h3>
                    <p style="font-family: var(--font-mono); font-size: 1.1rem; color: #d1d5db; line-height: 1.4;">
                        Data langsung disimpan secara real-time ke MySQL:
                    </p>
                    <ul style="list-style: none; margin-top: 8px; font-family: var(--font-mono); font-size: 1.15rem; color: var(--red-hover);">
                        <li>&#10148; <strong>Host:</strong> localhost</li>
                        <li>&#10148; <strong>Database:</strong> datadepin</li>
                        <li>&#10148; <strong>Tabel:</strong> sija2</li>
                        <li>&#10148; <strong>Engine:</strong> PHP & MariaDB/MySQL</li>
                    </ul>
                    <div style="margin-top: 15px;">
                        <a href="data.php" class="btn btn-secondary btn-sm btn-block">&#128203; [ BUKA DATABASE ]</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <strong>SIJA GAMEDEV ARENA</strong> - Pendaftaran Lomba Membuat Game Siswa SIJA</p>
            <p style="font-size: 0.95rem; margin-top: 5px;">Database: <code>datadepin</code> &bull; Tabel: <code>sija2</code> &bull; Retro Pixel Edition</p>
        </div>
    </footer>

    <!-- Script Tulisan Bergerak Mengetik (Typewriter Retro) -->
    <script>
    const textArray = [
        "REGISTRASI LOMBA GAME DEVELOPER SIJA 2026 TELAH DIBUKA...",
        "TUNJUKKAN KEMAMPUAN CODING & KREATIFITAS GAME TERBAIKMU!",
        "DAFTARKAN KARYA ORISINALMU & RAIH PIALA JUARA GAMEFEST!",
        "KATEGORI: 2D, 3D, RPG, EDUKASI, ARCADE & HORROR GAME!",
        "STATUS DATABASE: CONNECTED TO DATADEPIN.SIJA2"
    ];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typewriterElement = document.getElementById("typewriter");

    function typeEffect() {
        if (!typewriterElement) return;
        const currentText = textArray[textIndex];
        
        if (isDeleting) {
            typewriterElement.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typewriterElement.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
        }

        let typeSpeed = isDeleting ? 25 : 60;

        if (!isDeleting && charIndex === currentText.length) {
            typeSpeed = 2200; // Jeda saat kalimat selesai
            isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % textArray.length;
            typeSpeed = 400; // Jeda sebelum kalimat baru
        }

        setTimeout(typeEffect, typeSpeed);
    }

    document.addEventListener("DOMContentLoaded", typeEffect);
    </script>

</body>
</html>
