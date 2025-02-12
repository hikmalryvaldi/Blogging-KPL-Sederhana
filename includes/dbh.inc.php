<?php

// data source name
// dbname masih sementara
$dsn = "mysql:host=localhost;dbname=tubes_kpl";
$dbusername = "root";
$dbpassword = "";

try {
  // php data object
  $pdo = new PDO($dsn, $dbusername, $dbpassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Koneksi GAGAL!: " . $e->getMessage();
}
