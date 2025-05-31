<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // pengecekan token csrf
  if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("CSRF token tidak valid!");
  }

  // Setelah dicek, hapus token lama untuk mencegah replay attack
  unset($_SESSION["csrf_token"]);

  $username = trim($_POST["username"]); // spasi kosong di awal dan di akhir string
  $password = $_POST["pwd"];
  $email = trim($_POST["email"]);

  $token = bin2hex(random_bytes(32)); // Buat token baru untuk keperluan aktivasi

  try {
    require_once "dbh.inc.php";
    require_once "function.php";

    $error = [];

    // validasi
    if (isInputEmpty($username, $password, $email)) { // input jangan kosong
      $error["empty_input"] = "Tolong masukkan input yang kosong";
    }
    if (isEmailInvalid($email)) {
      $error["email_invalid"] = "Email yang anda masukan tidak valid"; // validasi email
    }
    if (isNameTaken($pdo, $username)) {
      $error["username_taken"] = "Username yang anda masukkan sudah ada";
    }
    if (isEmailTaken($pdo, $email)) {
      $error["email_taken"] = "Email yang anda masukkan sudah ada";
    }

    require_once "config_session.inc.php";

    if ($error) {
      $_SESSION["error"] = $error;
      $_SESSION["signup_data"] = [
        "username" => $username,
        "email" => $email
      ];
      header("Location: ../users/register.php");
      exit();
    }

    createUser($pdo, $username, $password, $email);

    header("Location: ../users/login.php?signup=success");
    exit();
  } catch (PDOException $e) {
    die("Query GAGAL: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php");
  exit();
}
