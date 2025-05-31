<?php
session_start();

// Validasi CSRF token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("❌ CSRF token tidak valid!");
  }

  // Validasi input
  $penulis = trim($_POST["penulis"]);
  $judul = trim($_POST["judul"]);
  $isi = trim($_POST["artikel_text"]);
  $id = $_SESSION["user_id"];

  if (empty($penulis) || empty($judul) || empty($isi)) {
    $_SESSION["error"] = "Semua field harus diisi!";
    header("Location: ../artikel/tambah.php");
    exit();
  }

  // Validasi file upload
  $gambar = $_FILES["gambar"]["name"]; // sama.jp
  $tmpName = $_FILES["gambar"]["tmp_name"];
  $maxSize = 10 * 1024 * 1024; // 10MB
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

  if (!empty($gambar)) {
    if ($_FILES["gambar"]["size"] > $maxSize) {
      $_SESSION["error"] = "Ukuran file terlalu besar. Maksimal ukuran yang diizinkan adalah 10MB.";
      header("Location: ../artikel/tambah.php");
      exit();
    }

    if (!in_array($_FILES["gambar"]["type"], $allowedTypes)) {
      $_SESSION["error"] = "Jenis file tidak diizinkan. Hanya file JPG, PNG, dan GIF yang diizinkan.";
      header("Location: ../artikel/tambah.php");
      exit();
    }

    // Generate nama file unik untuk menghindari konflik
    $gambar = uniqid() . "_" . basename($gambar); // 1231312_sama.jpg
    $folder = "../assets/img/" . $gambar;
  } else {
    $_SESSION["error"] = "File gambar harus diunggah.";
    header("Location: ../artikel/tambah.php");
    exit();
  }

  try {
    require_once "dbh.inc.php";

    // Query untuk menyimpan artikel baru
    $query = "INSERT INTO articles (penulis, judul, gambar, artikel_text, users_id) VALUES (:penulis, :judul, :gambar, :isi, :user_id);";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":penulis", $penulis);
    $stmt->bindParam(":judul", $judul);
    $stmt->bindParam(":gambar", $gambar);
    $stmt->bindParam(":isi", $isi);
    $stmt->bindParam(":user_id", $id);

    $stmt->execute();
    move_uploaded_file($tmpName, $folder);

    // Redirect ke halaman sukses
    $_SESSION["success"] = "Artikel berhasil dibuat!";
    header("Location: ../index.php");
    exit();
  } catch (PDOException $e) {
    $_SESSION["error"] = "Terjadi kesalahan saat membuat artikel: " . $e->getMessage();
    header("Location: ../artikel/tambah.php");
    exit();
  }
} else {
  header("Location: ../index.php");
  exit();
}
