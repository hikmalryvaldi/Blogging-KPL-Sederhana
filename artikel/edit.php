<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";

include_once "../includes/log_helper.php"; // Logging helper

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
<?php require_once "../includes/header.inc.php"; ?>

<div class="form-container">
  <form action="../includes/articleupdate.inc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $article["id"]; ?>">

    <!-- Menambahkan CSRF Token sebagai input hidden -->
    <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">

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
<?php require_once "../includes/footer.inc.php"; ?>