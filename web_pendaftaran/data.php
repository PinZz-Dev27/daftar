<?php
require_once 'koneksi.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';

// Query dengan filter pencarian
$whereClauses = [];
$params = [];
$types  = "";

if ($search !== '') {
    $whereClauses[] = "(`NAMA` LIKE ? OR `EMAIL` LIKE ? OR `COMMENT` LIKE ?)";
    $like = "%" . $search . "%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= "sss";
}

if ($gender !== '') {
    $whereClauses[] = "`GENDER` = ?";
    $params[] = $gender;
    $types .= "s";
}

$sql = "SELECT * FROM `sija2`";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " ORDER BY `NO` DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Statistik ringkasan dari tabel sija2 database datadepin
$statTotal = $conn->query("SELECT COUNT(*) as total FROM `sija2`")->fetch_assoc()['total'];
$statPria  = $conn->query("SELECT COUNT(*) as total FROM `sija2` WHERE `GENDER` LIKE '%laki%' OR `GENDER` = 'pria' OR `GENDER` = 'male'")->fetch_assoc()['total'];
$statWanita = $conn->query("SELECT COUNT(*) as total FROM `sija2` WHERE `GENDER` LIKE '%wanita%' OR `GENDER` = 'perempuan' OR `GENDER` = 'female'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar Lomba Game SIJA | Database datadepin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin: 25px 0;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: var(--cyan);
        }
        .stat-card.blue::before { background: var(--blue); }
        .stat-card.pink::before { background: #ec4899; }
        .stat-card.green::before { background: var(--success); }
        .stat-card .val {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 2px;
        }
        .stat-card .tit {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .sub {
            font-size: 0.78rem;
            color: var(--cyan);
            margin-top: 4px;
        }
        .btn-action-group {
            display: flex;
            gap: 6px;
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
                <li><a href="data.php" class="nav-link active">Data Peserta (<?= $statTotal ?>)</a></li>
                <li><a href="index.php" class="nav-link nav-link-cta">+ Tambah Peserta</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 30px; padding-bottom: 50px;">
        
        <!-- Header Halaman -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h1 style="font-size: 1.8rem; color: #fff;">&#128203; Data Siswa Peserta Lomba Game</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Database: <strong style="color: var(--cyan);">datadepin</strong> | Tabel: <strong style="color: var(--cyan);">sija2</strong>
                </p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="export_excel.php" class="btn btn-secondary" title="Unduh ke format Excel">
                    &#128190; Export Excel / CSV
                </a>
                <a href="index.php" class="btn btn-primary">
                    &#43; Formulir Baru
                </a>
            </div>
        </div>

        <!-- Notifikasi Pesan -->
        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'update_berhasil'): ?>
                <div class="alert alert-success">
                    <strong>Sukses!</strong> Data siswa berhasil diperbarui pada database <em>datadepin.sija2</em>.
                </div>
            <?php elseif ($_GET['pesan'] === 'hapus_berhasil'): ?>
                <div class="alert alert-success">
                    <strong>Sukses!</strong> Data siswa berhasil dihapus dari tabel <em>sija2</em>.
                </div>
            <?php elseif ($_GET['pesan'] === 'hapus_gagal'): ?>
                <div class="alert alert-danger">
                    <strong>Gagal!</strong> Terjadi kendala saat menghapus data.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Kartu Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="val"><?= $statTotal ?></div>
                <div class="tit">Total Data Siswa</div>
                <div class="sub">Tabel sija2</div>
            </div>
            <div class="stat-card blue">
                <div class="val"><?= $statPria ?></div>
                <div class="tit">Siswa Laki-laki</div>
                <div class="sub">Peserta Pria</div>
            </div>
            <div class="stat-card pink">
                <div class="val"><?= $statWanita ?></div>
                <div class="tit">Siswa Perempuan</div>
                <div class="sub">Peserta Putri</div>
            </div>
            <div class="stat-card green">
                <div class="val">SIJA</div>
                <div class="tit">Program Keahlian</div>
                <div class="sub">SMK 4 Tahun</div>
            </div>
        </div>

        <!-- Form Filter & Pencarian -->
        <div class="filter-bar">
            <form action="data.php" method="GET" class="filter-form">
                <input type="text" name="search" class="filter-control" placeholder="Cari Siswa / Judul Game / Engine..." value="<?= htmlspecialchars($search) ?>" style="min-width: 250px;">
                
                <select name="gender" class="filter-control">
                    <option value="">Semua Gender</option>
                    <option value="Laki-laki" <?= ($gender === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($gender === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                </select>

                <button type="submit" class="btn btn-primary btn-sm">&#128269; Cari Data</button>
                <?php if ($search !== '' || $gender !== ''): ?>
                    <a href="data.php" class="btn btn-secondary btn-sm">&#8635; Reset Filter</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Daftar Siswa Pendaftar (<?= $result->num_rows ?> Data)</span>
                <span style="font-size: 0.85rem; color: var(--text-dim);">Diurutkan berdasarkan entri terbaru</span>
            </div>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Peserta</th>
                            <th>Nama Siswa & Gender</th>
                            <th>Kelas</th>
                            <th>Judul Game & Engine</th>
                            <th>Genre & Platform</th>
                            <th>Email & Demo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $no = 1; while ($row = $result->fetch_assoc()): 
                                $game = parseGameComment($row['COMMENT']);
                                $regId = "SIJA-" . str_pad($row['NO'], 4, '0', STR_PAD_LEFT);
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong style="color: var(--cyan);"><?= $regId ?></strong>
                                    </td>
                                    <td>
                                        <strong><?= !empty(trim($row['NAMA'])) ? htmlspecialchars($row['NAMA']) : '<em style="color:var(--text-dim);">(Nama Belum Diisi)</em>' ?></strong>
                                        <div style="font-size: 0.78rem; color: var(--text-muted);"><?= htmlspecialchars($row['GENDER'] ?? '-') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?= htmlspecialchars($game['kelas']) ?></span>
                                    </td>
                                    <td>
                                        <strong style="color: #ffffff;">&#127918; <?= htmlspecialchars($game['judul_game']) ?></strong>
                                        <div style="font-size: 0.78rem; color: var(--text-dim);">&#9881;&#65039; <?= htmlspecialchars($game['engine']) ?></div>
                                    </td>
                                    <td>
                                        <div><?= htmlspecialchars($game['genre']) ?></div>
                                        <div style="font-size: 0.78rem; color: var(--text-dim);">&#128187; <?= htmlspecialchars($game['platform']) ?></div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.82rem; color: var(--text-muted);">&#9993;&#65039; <?= htmlspecialchars($row['EMAIL']) ?></div>
                                        <?php if (!empty($row['WEBSITE'])): ?>
                                            <div style="font-size: 0.75rem; margin-top: 3px;">
                                                <a href="<?= htmlspecialchars($row['WEBSITE']) ?>" target="_blank" rel="noopener noreferrer">&#128279; Link Demo &rarr;</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-action-group">
                                            <a href="detail.php?id=<?= $row['NO'] ?>" class="btn btn-secondary btn-sm" title="Lihat Kartu / Detail">
                                                &#128065;
                                            </a>
                                            <a href="edit.php?id=<?= $row['NO'] ?>" class="btn btn-warning btn-sm" title="Edit Data">
                                                &#9998;
                                            </a>
                                            <a href="hapus.php?id=<?= $row['NO'] ?>" class="btn btn-danger btn-sm" title="Hapus Data">
                                                &#128465;
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <div style="font-size: 2.5rem; margin-bottom: 10px;">&#128194;</div>
                                    <p>Tidak ada data pendaftar yang cocok dengan filter.</p>
                                    <div style="margin-top: 15px;">
                                        <a href="index.php" class="btn btn-primary btn-sm">+ Daftarkan Siswa Baru</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <span style="font-size: 0.85rem; color: var(--text-muted);">
                    Menampilkan <?= $result->num_rows ?> data dari total <?= $statTotal ?> data di database.
                </span>
                <a href="#top" style="font-size: 0.85rem;">&uarr; Ke Atas</a>
            </div>
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
