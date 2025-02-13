<?php
require_once "../includes/dbh.inc.php";

$id = $_GET["id"];

$query = "SELECT * FROM articles WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

$article = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form action="../includes/articleupdate.inc.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $article["id"]; ?>">

  <input type="text" name="penulis" value="<?= $article["penulis"]; ?>">
  <input type="text" name="judul" value="<?= $article["judul"]; ?>">
  <input type="file" name="gambar">

  <textarea name="artikel_text"><?= $article["artikel_text"]; ?></textarea>

  <button type="submit">Update</button>
</form>