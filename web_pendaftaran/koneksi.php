<?php
// Pengaturan Koneksi Database
$host     = "localhost";
$username = "root";
$password = ""; // Ubah jika MySQL Ubuntu Anda memiliki password
$database = "datadepin";

// Nonaktifkan uncaught exception mysqli di PHP 8.1+ agar bisa ditangkap manual
mysqli_report(MYSQLI_REPORT_OFF);

// 1. Hubungkan ke MySQL
try {
    $conn = @new mysqli($host, $username, $password);
} catch (Exception $e) {
    $conn = false;
}

if (!$conn || $conn->connect_error) {
    $errorMsg = $conn ? $conn->connect_error : ($e ? $e->getMessage() : 'Access denied');
    die("<div style='font-family:sans-serif; padding:25px; background:#1e1526; color:#fca5a5; border:1px solid #ef4444; border-radius:10px; margin:30px auto; max-width:700px;'>
        <h2 style='color:#ef4444; margin-top:0;'>⚠️ Koneksi ke MySQL Gagal!</h2>
        <p><strong>Penyebab:</strong> <code>" . htmlspecialchars($errorMsg) . "</code></p>
        <hr style='border:0; border-top:1px solid #3b2042; margin:15px 0;'>
        <h3 style='color:#38bdf8;'>Cara Mengatasi di Ubuntu / Linux:</h3>
        <p style='color:#e2e8f0;'>Di Ubuntu, MySQL secara default mengunci user <code>root</code> (menggunakan plugin <em>auth_socket</em>), sehingga Apache/PHP tidak diizinkan masuk tanpa password atau tanpa hak akses.</p>
        <p style='color:#e2e8f0;'>Silakan buka terminal Ubuntu Anda dan jalankan perintah berikut:</p>
        <pre style='background:#0b0f19; color:#67e8f9; padding:12px; border-radius:6px; overflow-x:auto;'>sudo mysql</pre>
        <p style='color:#e2e8f0;'>Lalu ketikkan query SQL ini di dalam MySQL:</p>
        <pre style='background:#0b0f19; color:#a7f3d0; padding:12px; border-radius:6px; overflow-x:auto;'>ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';
FLUSH PRIVILEGES;
EXIT;</pre>
        <p style='color:#e2e8f0;'>Setelah itu, refresh halaman ini. Jika MySQL Anda menggunakan password, sesuaikan nilai <code>\$password</code> di dalam file <code>letphp/koneksi.php</code>.</p>
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
