<?php
// UPLOAD GAMBAR BELUM AMAN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $penulis = $_POST["penulis"];
  $judul = $_POST["judul"];
  $gambar = $_FILES["gambar"]["name"];
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $folder = "../assets/img/" . $gambar;
  $isi = $_POST["artikel_text"];

  try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO articles (penulis, judul, gambar, artikel_text) VALUES (:penulis, :judul, :gambar, :isi);";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":penulis", $penulis);
    $stmt->bindParam(":judul", $judul);
    $stmt->bindParam(":gambar", $gambar);
    $stmt->bindParam(":isi", $isi);

    $stmt->execute();
    move_uploaded_file($tmpName, $folder);

    $pdo = null;
    $stmt = null;

    header("Location: ../index.php");

    die();
  } catch (PDOException $e) {
    die("Query GAGAL: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php");
}
