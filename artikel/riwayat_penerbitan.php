<?php
require_once "../includes/dbh.inc.php";

$id = $_GET["id"];

$query = "SELECT * FROM histories WHERE articles_id = :id ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$histories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Riwayat Revisi</h3>
<ul>
  <?php foreach ($histories as $history) : ?>
    <li>
      <strong>Judul:</strong> <?= $history["judul"]; ?> <br>
      <strong>Gambar:</strong> <?= $history["gambar"] ? "<img src='../assets/img/" . $history["gambar"] . "' width='100'>" : "Tidak ada"; ?> <br>
      <strong>Isi:</strong> <?= $history["artikel_text"]; ?> <br>
      <strong>Tanggal Revisi:</strong> <?= $history["created_at"]; ?> <br>
    </li>
    <hr>
  <?php endforeach; ?>
</ul>