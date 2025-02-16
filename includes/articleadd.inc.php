<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $penulis = $_POST["penulis"];
  $judul = $_POST["judul"];
  $gambar = $_FILES["gambar"]["name"];
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $folder = "../assets/img/" . $gambar;
  $isi = $_POST["artikel_text"];
  $id = $_SESSION["user_id"];

  // Mengatur ukuran maksimal (contoh: 10MB) dan jenis file yang diizinkan
  $maxSize = 10 * 1024 * 1024; // 10MB
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

  // Memeriksa ukuran file
  if ($_FILES["gambar"]["size"] > $maxSize) {
    die("Ukuran file terlalu besar. Maksimal ukuran yang diizinkan adalah 10MB.");
  }

  // Memeriksa jenis file
  if (!in_array($_FILES["gambar"]["type"], $allowedTypes)) {
    die("Jenis file tidak diizinkan. Hanya file JPG, PNG, dan GIF yang diizinkan.");
  }

  try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO articles (penulis, judul, gambar, artikel_text, users_id) VALUES (:penulis, :judul, :gambar, :isi, :user_id);";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":penulis", $penulis);
    $stmt->bindParam(":judul", $judul);
    $stmt->bindParam(":gambar", $gambar);
    $stmt->bindParam(":isi", $isi);
    $stmt->bindParam(":user_id", $id);

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
