<?php
session_start();

// Validasi CSRF token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("❌ CSRF token tidak valid!");
  }

  // Validasi input
  $id = $_POST["id"];
  $penulis = trim($_POST["penulis"]);
  $judul = trim($_POST["judul"]);
  $isi = trim($_POST["artikel_text"]);
  $status = $_POST["status"];

  if (empty($penulis) || empty($judul) || empty($isi)) {
    $_SESSION["error"] = "Semua field harus diisi!";
    header("Location: ../articles/edit.php?id=" . $id);
    exit();
  }

  // Validasi file upload
  $gambarBaru = $_FILES["gambar"]["name"];
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $maxSize = 10 * 1024 * 1024; // 10MB
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

  if (!empty($gambarBaru)) {
    if ($_FILES["gambar"]["size"] > $maxSize) {
      $_SESSION["error"] = "Ukuran file terlalu besar. Maksimal ukuran yang diizinkan adalah 10MB.";
      header("Location: ../articles/edit.php?id=" . $id);
      exit();
    }

    if (!in_array($_FILES["gambar"]["type"], $allowedTypes)) {
      $_SESSION["error"] = "Jenis file tidak diizinkan. Hanya file JPG, PNG, dan GIF yang diizinkan.";
      header("Location: ../articles/edit.php?id=" . $id);
      exit();
    }

    // Generate nama file unik untuk menghindari konflik
    $gambarBaru = uniqid() . "_" . basename($gambarBaru);
    $folder = "../assets/img/" . $gambarBaru;
  }

  try {
    require_once "dbh.inc.php";

    // Ambil data artikel lama
    $queryOld = "SELECT * FROM articles WHERE id = :id";
    $stmtOld = $pdo->prepare($queryOld);
    $stmtOld->bindParam(":id", $id);
    $stmtOld->execute();
    $oldArticle = $stmtOld->fetch(PDO::FETCH_ASSOC);

    if (!$oldArticle) {
      die("Artikel tidak ditemukan.");
    }

    // Simpan revisi artikel ke tabel histories
    $queryInsertRevision = "INSERT INTO histories (judul, gambar, artikel_text, articles_id, aksi) 
                            VALUES (:judul, :gambar, :isi, :articles_id, :status)";
    $stmtInsertRevision = $pdo->prepare($queryInsertRevision);
    $stmtInsertRevision->bindParam(":judul", $oldArticle["judul"]);
    $stmtInsertRevision->bindParam(":gambar", $oldArticle["gambar"]);
    $stmtInsertRevision->bindParam(":isi", $oldArticle["artikel_text"]);
    $stmtInsertRevision->bindParam(":articles_id", $id);
    $stmtInsertRevision->bindParam(":status", $oldArticle["aksi"]);
    $stmtInsertRevision->execute();

    // Update artikel
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

    // Redirect ke halaman sukses
    $_SESSION["success"] = "Artikel berhasil diupdate!";
    header("Location: ../index.php");
    exit();
  } catch (PDOException $e) {
    $_SESSION["error"] = "Terjadi kesalahan saat mengupdate artikel: " . $e->getMessage();
    header("Location: ../articles/edit.php?id=" . $id);
    exit();
  }
} else {
  header("Location: ../index.php");
  exit();
}
