<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["pwd"];
  $email = $_POST["email"];

  try {
    // include("../includes/dbh.inc.php");
    require_once "dbh.inc.php";

    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :password, :email);";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":email", $email);

    $stmt->execute();

    $pdo = null;
    $stmt = null;

    header("Location: ../index.php");

    die();
  } catch (PDOException $e) {
    die("Query GAGAL: " . $e->getMessage());
  }
} else {
  header("Location: ../index.php");
}
