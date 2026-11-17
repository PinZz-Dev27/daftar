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
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="data.php" class="nav-link nav-link-cta">Lihat Data Peserta</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section">
            <span class="hero-pill">&#127918; SIJA Game Development Competition</span>
            <h1 class="hero-title">Pendaftaran Lomba Game Siswa SIJA</h1>
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
                    <span class="num">Piala & Sertifikat</span>
                    <span class="label">Hadiah Juara</span>
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
                            <h3 style="color: var(--cyan); font-size: 1.05rem; margin-bottom: 16px; border-bottom: 1px dashed var(--border-color); padding-bottom: 8px;">
                                A. Identitas Siswa SIJA
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
                            <h3 style="color: var(--cyan); font-size: 1.05rem; margin: 26px 0 16px 0; border-bottom: 1px dashed var(--border-color); padding-bottom: 8px;">
                                B. Detail Proyek Game yang Dilombakan
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
                                    &#128640; Simpan Data Pendaftaran Game
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Informasi -->
            <div class="sidebar-wrapper" id="aturan">
                
                <div class="info-card">
                    <h3 class="info-title">&#128203; Syarat & Ketentuan Lomba</h3>
                    <ul class="info-list">
                        <li>Peserta adalah siswa aktif jurusan SIJA (Kelas X, XI, XII, atau XIII).</li>
                        <li>Dapat diikuti secara individu maupun perwakilan tim.</li>
                        <li>Game dapat bertema edukasi teknologi, aksi, strategi, atau petualangan.</li>
                        <li>Tidak mengandung unsur SARA, ujaran kebencian, atau konten negatif.</li>
                        <li>Free assets (audio/grafis) diperbolehkan dengan menyertakan kredit lisensi.</li>
                        <li>Finalis akan mempresentasikan build game di hadapan dewan juri SIJA.</li>
                    </ul>
                </div>

                <div class="info-card">
                    <h3 class="info-title">&#128337; Jadwal Kegiatan</h3>
                    <ul class="info-list">
                        <li><strong>Pendaftaran Online:</strong> Dibuka Sekarang</li>
                        <li><strong>Technical Meeting:</strong> Info via Email Siswa</li>
                        <li><strong>Batas Pengumpulan File:</strong> H-5 Penjurian</li>
                        <li><strong>Showcase & Presentasi:</strong> Lab Jaringan & Komputer SIJA</li>
                        <li><strong>Penyerahan Hadiah:</strong> Sesi Penutupan Acara</li>
                    </ul>
                </div>

                <div class="info-card">
                    <h3 class="info-title">&#128190; Status Database MySQL</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                        Data langsung disimpan secara real-time ke MySQL:
                    </p>
                    <ul style="list-style: none; margin-top: 8px; font-size: 0.85rem; color: var(--cyan);">
                        <li>&#10148; <strong>Host:</strong> localhost</li>
                        <li>&#10148; <strong>Database:</strong> datadepin</li>
                        <li>&#10148; <strong>Tabel:</strong> sija2</li>
                        <li>&#10148; <strong>Engine:</strong> PHP 7/8 Native + MySQLi</li>
                    </ul>
                    <div style="margin-top: 15px;">
                        <a href="data.php" class="btn btn-secondary btn-sm btn-block">&#128203; Buka Daftar Peserta</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <strong>SIJA GameDev Arena</strong> - Pendaftaran Lomba Membuat Game Siswa SIJA</p>
            <p style="font-size: 0.78rem; margin-top: 5px;">Database: <code>datadepin</code> &bull; Tabel: <code>sija2</code> &bull; HTML, CSS & PHP SAJA</p>
        </div>
    </footer>

</body>
</html>
