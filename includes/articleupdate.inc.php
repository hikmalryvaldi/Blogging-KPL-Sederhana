<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $penulis = $_POST["penulis"];
  $judul = $_POST["judul"];
  $gambarBaru = $_FILES["gambar"]["name"];
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $folder = "../assets/img/" . $gambarBaru;
  $isi = $_POST["artikel_text"];
  $status = $_POST["status"];

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

    $queryOld = "SELECT * FROM articles WHERE id = :id";
    $stmtOld = $pdo->prepare($queryOld);
    $stmtOld->bindParam(":id", $id);
    $stmtOld->execute();
    $oldArticle = $stmtOld->fetch(PDO::FETCH_ASSOC);

    if (!$oldArticle) {
      die("Artikel tidak ditemukan.");
    }

    $gambarLama = $oldArticle["gambar"];
    $gambarSimpan = !empty($gambarBaru) ? $gambarBaru : $gambarLama;

    $queryInsertRevision = "INSERT INTO histories (judul, gambar, artikel_text, articles_id, aksi) 
                            VALUES (:judul, :gambar, :isi, :articles_id, :status)";
    $stmtInsertRevision = $pdo->prepare($queryInsertRevision);
    $stmtInsertRevision->bindParam(":judul", $oldArticle["judul"]);
    $stmtInsertRevision->bindParam(":gambar", $oldArticle["gambar"]);
    $stmtInsertRevision->bindParam(":isi", $oldArticle["artikel_text"]);
    $stmtInsertRevision->bindParam(":articles_id", $id);
    $stmtInsertRevision->bindParam(":status", $oldArticle["aksi"]);
    $stmtInsertRevision->execute();

    if (!empty($gambarBaru)) {
      $queryUpdate = "UPDATE articles SET penulis = :penulis, judul = :judul, gambar = :gambar, artikel_text = :isi, aksi = :status WHERE id = :id";
    } else {
      $queryUpdate = "UPDATE articles SET penulis = :penulis, judul = :judul, artikel_text = :isi, aksi = :status WHERE id = :id";
    }

    $stmtUpdate = $pdo->prepare($queryUpdate);
    $stmtUpdate->bindParam(":penulis", $penulis);
    $stmtUpdate->bindParam(":judul", $judul);
    $stmtUpdate->bindParam(":isi", $isi);
    $stmtUpdate->bindParam(":id", $id);
    $stmtUpdate->bindParam(":status", $status);

    if (!empty($gambarBaru)) {
      $stmtUpdate->bindParam(":gambar", $gambarBaru);
      move_uploaded_file($tmpName, $folder);
    }

    $stmtUpdate->execute();

    $pdo = null;
    $stmtInsertRevision = null;
    $stmtUpdate = null;

    header("Location: ../index.php");
    die();
  } catch (PDOException $e) {
    die("Query GAGAL: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php");
}
