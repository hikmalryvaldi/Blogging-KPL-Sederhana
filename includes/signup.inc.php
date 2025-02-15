<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["pwd"];
  $email = $_POST["email"];

  try {
    require_once "dbh.inc.php";
    require_once "function.php";

    $error = [];

    if (isInputEmpty($username, $password, $email)) {
      $error["empty_input"] = "Tolong masukkan input yang kosong";
    }
    if (isEmailInvalid($email)) {
      $error["email_invalid"] = "Email yang anda masukan tidak valid";
    }
    if (isNameTaken($pdo, $username)) {
      $error["username_taken"] = "Username yang anda masukkan sudah ada";
    }
    if (isEmailTaken($pdo, $email)) {
      $error["email_taken"] = "Email yang anda masukkan sudah ada";
    }

    session_start();

    if ($error) {
      $_SESSION["error"] = $error;

      $signupData = [
        "username" => $username,
        "email" => $email
      ];

      $_SESSION["signup_data"] = $signupData;
      header("Location: ../users/register.php");



      die();
    }

    createUser($pdo, $username, $password, $email);

    header("Location: ../users/login.php?signup=success");

    $pdo = null;
    $stmt = null;

    die();
  } catch (PDOException $e) {
    die("Query GAGAL: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php");
  die();
}
