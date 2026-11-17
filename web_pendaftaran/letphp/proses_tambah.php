<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Ambil dan bersihkan data input
    $nama       = trim($_POST['nama'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $kelas      = trim($_POST['kelas'] ?? '');
    $judul_game = trim($_POST['judul_game'] ?? '');
    $genre      = trim($_POST['genre'] ?? '');
    $engine     = trim($_POST['engine'] ?? '');
    $platform   = trim($_POST['platform'] ?? '');
    $website    = trim($_POST['website'] ?? '');
    $deskripsi  = trim($_POST['deskripsi'] ?? '');

    // Validasi input penting
    if (empty($nama) || empty($gender) || empty($email) || empty($kelas) || 
        empty($judul_game) || empty($genre) || empty($engine) || empty($platform)) {
        
        header("Location: index.php?pesan=gagal&error=" . urlencode("Semua kolom bertanda bintang wajib diisi!"));
        exit;
    }

    // Format detail game ke dalam format terstruktur yang disimpan pada kolom COMMENT
    $comment = formatGameComment($judul_game, $kelas, $genre, $engine, $platform, $deskripsi);

    // Siapkan query INSERT ke tabel sija2 pada database datadepin
    $sql = "INSERT INTO `sija2` (`NAMA`, `EMAIL`, `WEBSITE`, `COMMENT`, `GENDER`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $nama, $email, $website, $comment, $gender);

        if ($stmt->execute()) {
            $new_id = $stmt->insert_id;
            $stmt->close();
            // Arahkan ke kartu pendaftaran / detail peserta
            header("Location: detail.php?id=" . $new_id . "&pesan=terdaftar");
            exit;
        } else {
            $err = $stmt->error;
            $stmt->close();
            header("Location: index.php?pesan=gagal&error=" . urlencode("Gagal eksekusi query: " . $err));
            exit;
        }
    } else {
        header("Location: index.php?pesan=gagal&error=" . urlencode("Gagal prepare statement: " . $conn->error));
        exit;
    }

} else {
    header("Location: index.php");
    exit;
}
?>
