<?php
// Pengaturan Koneksi Database
$host     = "localhost";
$username = "root";
$password = "";
$database = "datadepin";

// 1. Hubungkan ke MySQL
$conn = @new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("<div style='font-family:sans-serif; padding:20px; background:#ffebee; color:#c62828; border-radius:8px; margin:20px;'>
        <h3>Koneksi MySQL Gagal!</h3>
        <p>Pastikan Apache & MySQL di XAMPP Control Panel sudah dalam status <strong>Start</strong>.</p>
        <p>Error: " . htmlspecialchars($conn->connect_error) . "</p>
    </div>");
}

// 2. Buat database 'datadepin' jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($database);

// 3. Buat tabel 'sija2' jika belum ada (sesuai struktur tabel resmi datadepin.sija2)
$sqlTable = "CREATE TABLE IF NOT EXISTS `sija2` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `WEBSITE` varchar(255) NOT NULL,
  `COMMENT` text NOT NULL,
  `GENDER` varchar(20) NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$conn->query($sqlTable);
$conn->set_charset("utf8mb4");

// Fungsi pembantu untuk mem-parsing data detail game dari kolom COMMENT
function parseGameComment($comment) {
    $data = [
        'judul_game' => '',
        'kelas'      => '-',
        'genre'      => 'Game SIJA',
        'engine'     => 'Custom / Lainnya',
        'platform'   => 'PC / Multiplatform',
        'deskripsi'  => ''
    ];
    
    if (preg_match('/\[JUDUL_GAME\]:\s*(.*?)(?=\n\[|$)/s', $comment, $m)) {
        $data['judul_game'] = trim($m[1]);
    }
    if (preg_match('/\[KELAS\]:\s*(.*?)(?=\n\[|$)/s', $comment, $m)) {
        $data['kelas'] = trim($m[1]);
    }
    if (preg_match('/\[GENRE\]:\s*(.*?)(?=\n\[|$)/s', $comment, $m)) {
        $data['genre'] = trim($m[1]);
    }
    if (preg_match('/\[ENGINE\]:\s*(.*?)(?=\n\[|$)/s', $comment, $m)) {
        $data['engine'] = trim($m[1]);
    }
    if (preg_match('/\[PLATFORM\]:\s*(.*?)(?=\n\[|$)/s', $comment, $m)) {
        $data['platform'] = trim($m[1]);
    }
    if (preg_match('/\[DESKRIPSI\]:\s*(.*)/s', $comment, $m)) {
        $data['deskripsi'] = trim($m[1]);
    }

    if (empty($data['judul_game'])) {
        $clean = trim($comment);
        $data['judul_game'] = !empty($clean) ? mb_substr($clean, 0, 35) : 'Game Siswa SIJA';
        $data['deskripsi'] = $clean;
    }
    
    return $data;
}

// Fungsi pembantu untuk format kolom COMMENT
function formatGameComment($judul_game, $kelas, $genre, $engine, $platform, $deskripsi) {
    return "[JUDUL_GAME]: " . trim($judul_game) . "\n"
         . "[KELAS]: " . trim($kelas) . "\n"
         . "[GENRE]: " . trim($genre) . "\n"
         . "[ENGINE]: " . trim($engine) . "\n"
         . "[PLATFORM]: " . trim($platform) . "\n"
         . "[DESKRIPSI]: " . trim($deskripsi);
}
?>
