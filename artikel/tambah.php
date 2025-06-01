<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";
require_once "../includes/header.inc.php";

include_once "../includes/log_helper.php"; // Tambahkan logging helper

// Global error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    write_log("PHP Error [$errno]: $errstr in $errfile on line $errline", 'ERROR');
});
set_exception_handler(function ($exception) {
    write_log("Uncaught Exception: " . $exception->getMessage(), 'ERROR');
});
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        write_log("Fatal Error: {$error['message']} in {$error['file']} on line {$error['line']}", 'ERROR');
    }
});



// Memastikan CSRF token ada di session
if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // Buat token jika belum ada
}

$csrf_token = $_SESSION["csrf_token"]; // Ambil token dari session

if (!isset($_SESSION["user_id"])) {
  header("Location: ../users/login.php"); // Redirect ke halaman login jika belum login
  exit();
}
  // Log jika tambah gagal
  include_once 'includes/log_helper.php';

  $judul = $_POST['judul'];
  $penulis = $_SESSION['username'] ?? 'unknown';

  write_log("User '$penulis' menambahkan artikel baru dengan judul '$judul'", 'INFO');

// Jika ada error, tampilkan pesan error
if (empty($_POST['judul'])) {
    write_log("User '$penulis' gagal menambahkan artikel karena judul kosong", 'ERROR');
    echo "Judul tidak boleh kosong!";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Artikel</title>
  <link rel="stylesheet" href="../assets/css/tambahstyle.css">
</head>

<body>










  <?php if (isset($_SESSION['error']))

    echo $_SESSION['error']
  ?>
  <div class="container">
    <h2>Tambah Artikel</h2>
    <form action="../includes/articleadd.inc.php" method="post" enctype="multipart/form-data">
      <!-- Menambahkan CSRF Token sebagai input hidden -->
      <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">

      <label for="penulis">Nama Penulis:</label>
      <input type="text" name="penulis" placeholder="Masukkan nama penulis...">

      <label for="judul">Judul Artikel:</label>
      <input type="text" name="judul" placeholder="Masukkan judul artikel...">

      <label for="gambar">Unggah Gambar:</label>
      <input type="file" name="gambar" accept="image/*">

      <label for="artikel_text">Isi Artikel:</label>
      <textarea name="artikel_text" rows="5" placeholder="Masukkan isi artikel..."></textarea>

      <button type="submit">Tambah Artikel</button>
    </form>
  </div>
  <!-- <?php require_once "../includes/footer.inc.php"; ?> -->
</body>

</html>