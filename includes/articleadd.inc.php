<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $penulis = $_POST["penulis"];
  $judul = $_POST["judul"];
  // $gambar = $_POST["gambar"];
  $isi = $_POST["artikel_text"];

  try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO articles (penulis, judul, artikel_text) VALUES (:penulis, :judul, :isi);";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":penulis", $penulis);
    $stmt->bindParam(":judul", $judul);
    // $stmt->bindParam(":gambar", $gambar);
    $stmt->bindParam(":isi", $isi);

    $stmt->execute();

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
