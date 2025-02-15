<?php
require_once "../includes/dbh.inc.php";

$id = $_GET["id"];

$query = "SELECT * FROM histories WHERE articles_id = :id ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$histories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Revisi</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="history-container">
    <h3>Riwayat Revisi</h3>
    <ul class="history-list">
      <?php foreach ($histories as $history) : ?>
        <li class="history-item">
          <div class="history-detail">
            <strong>Judul:</strong> <?= $history["judul"]; ?> <br>
            <strong>Gambar:</strong> <br> <?= $history["gambar"] ? "<img src='../assets/img/" . $history["gambar"] . "' width='100'>" : "Tidak ada"; ?> <br>
            <strong>Status:</strong> <span class="status"><?= $history["aksi"]; ?></span> <br>
            <strong>Isi:</strong>
            <div class="article-text"><?= $history["artikel_text"]; ?></div> <br>
            <strong>Tanggal Revisi:</strong> <span class="timestamp"><?= $history["created_at"]; ?></span> <br>
          </div>
        </li>
        <hr class="history-divider">
      <?php endforeach; ?>
    </ul>
  </div>
</body>

</html>