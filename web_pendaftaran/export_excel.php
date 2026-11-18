<?php
require_once 'koneksi.php';

// Atur header HTTP untuk unduhan file Excel (.xls)
$filename = "Data_Peserta_Lomba_Game_SIJA_" . date('Ymd_His') . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM `sija2` ORDER BY `NO` ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Peserta SIJA GameDev</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #000000;
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #b91c1c;
            color: #ffffff;
            font-weight: bold;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
        }
        .header-sub {
            font-size: 10pt;
            color: #555555;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="header-title">DATA PESERTA LOMBA MEMBUAT GAME - SISWA SIJA</div>
    <div class="header-sub">Database: <b>datadepin</b> | Tabel: <b>sija2</b> | Tanggal Ekspor: <?= date('d/m/Y H:i') ?> WIB</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Registrasi</th>
                <th>Nama Lengkap Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Kelas SIJA</th>
                <th>Email Siswa</th>
                <th>Judul Game</th>
                <th>Genre / Kategori</th>
                <th>Game Engine</th>
                <th>Target Platform</th>
                <th>Website / Link Demo</th>
                <th>Sinopsis & Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result && $result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $game = parseGameComment($row['COMMENT']);
                    $regId = "SIJA-" . str_pad($row['NO'], 4, '0', STR_PAD_LEFT);
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($regId) . "</td>";
                    echo "<td>" . htmlspecialchars($row['NAMA']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['GENDER']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['kelas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['EMAIL']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['judul_game']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['genre']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['engine']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['platform']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['WEBSITE']) . "</td>";
                    echo "<td>" . htmlspecialchars($game['deskripsi']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12' style='text-align:center;'>Belum ada data pendaftar di database datadepin.sija2.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
