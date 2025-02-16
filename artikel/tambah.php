<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: ../users/login.php"); // Redirect ke halaman login jika belum login
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Artikel</title>
  <link rel="stylesheet" href="../assets/css/tambah.css">
</head>

<body>
  <div class="container">
    <h2>Tambah Artikel</h2>
    <form action="../includes/articleadd.inc.php" method="post" enctype="multipart/form-data">
      <label for="penulis">Nama Penulis:</label>
      <input type="text" name="penulis" required placeholder="Masukkan nama penulis...">

      <label for="judul">Judul Artikel:</label>
      <input type="text" name="judul" required placeholder="Masukkan judul artikel...">

      <label for="gambar">Unggah Gambar:</label>
      <input type="file" name="gambar" accept="image/*">

      <label for="artikel_text">Isi Artikel:</label>
      <textarea name="artikel_text" rows="5" required placeholder="Masukkan isi artikel..."></textarea>

      <button type="submit">Tambah Artikel</button>
    </form>
  </div>
</body>

</html>