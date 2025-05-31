<?php
session_start();

// Pastikan CSRF token ada di session, jika belum ada buat token baru
if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // Membuat token CSRF
}

// Memeriksa apakah form logout dikirim melalui POST dan validasi token CSRF
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Cek apakah token CSRF ada di POST dan valid
  if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("❌ CSRF token tidak valid!"); // Token tidak valid
  }

  // Token valid, lakukan logout
  session_unset();
  session_destroy();
  header("Location: ../index.php"); // Redirect setelah logout
  exit();
}
