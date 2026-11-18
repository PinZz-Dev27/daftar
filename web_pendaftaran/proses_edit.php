<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    $no         = intval($_POST['no'] ?? 0);
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

    if ($no <= 0 || empty($nama) || empty($gender) || empty($email) || empty($kelas) || 
        empty($judul_game) || empty($genre) || empty($engine) || empty($platform)) {
        
        die("Data yang dikirim tidak lengkap! <a href='data.php'>Kembali ke Data Peserta</a>");
    }

    $comment = formatGameComment($judul_game, $kelas, $genre, $engine, $platform, $deskripsi);

    $sql = "UPDATE `sija2` SET `NAMA` = ?, `EMAIL` = ?, `WEBSITE` = ?, `COMMENT` = ?, `GENDER` = ? WHERE `NO` = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nama, $email, $website, $comment, $gender, $no);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: data.php?pesan=update_berhasil");
            exit;
        } else {
            die("Gagal memperbarui data: " . $stmt->error);
        }
    } else {
        die("Kesalahan query: " . $conn->error);
    }

} else {
    header("Location: data.php");
    exit;
}
?>
