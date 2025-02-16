<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: ../users/login.php");
  exit();
}
$id = $_GET["id"];

$query = "SELECT * FROM articles WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

$article = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<head>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<div class="form-container">
  <form action="../includes/articleupdate.inc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $article["id"]; ?>">

    <label for="penulis">Penulis</label>
    <input type="text" name="penulis" value="<?= $article["penulis"]; ?>">

    <label for="judul">Judul</label>
    <input type="text" name="judul" value="<?= $article["judul"]; ?>">

    <label for="gambar">Gambar</label>
    <input type="file" name="gambar">

    <label for="status">Status</label>
    <select name="status">
      <option value="public">Public</option>
      <option value="private">Private</option>
    </select>


    <textarea name="artikel_text"><?= $article["artikel_text"]; ?></textarea>

    <button type="submit">Update</button>
  </form>
</div>