<?php

// contrller
function isInputEmpty(string $username, string  $password, string  $email) // cek jika salah satu input kosong
{
  if (empty($username) || empty($password) || empty($email)) {
    return true;
  } else {
    return false;
  }
}

// contrller
function isEmailInvalid(string $email) // cek jika email tidak valid
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  } else {
    return false;
  }
}

// model
function get_username(object $pdo, string $username) // ambil username yang sudah ada
{
  $query = "SELECT username FROM users WHERE username = :username;"; // named placholder
  $stmt = $pdo->prepare($query); //
  $stmt->bindParam(":username", $username); // raka
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// contrller
function isNameTaken(object $pdo, string $username) // jika ada username return true
{
  if (get_username($pdo, $username)) {
    return true;
  } else {
    return false;
  }
}

// model
function get_email(object $pdo, string $email)
{
  $query = "SELECT email FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// contrller
function isEmailTaken(object $pdo, string $email)
{
  if (get_email($pdo, $email)) {
    return true;
  } else {
    return false;
  }
}

// view
function checkSignUpError()
{
  if ($_SESSION["error"]) {
    $errors = $_SESSION["error"];

    // echo "<br>";

    foreach ($errors as $error) {
      echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }

    unset($_SESSION["error"]);
  }
}

function setUser(object $pdo, string $username, string  $password, string  $email)
{
  $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :password, :email);";
  $stmt = $pdo->prepare($query);

  $options = [
    "cost" => 12
  ]; // tingkatan = tingkat 12 

  $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":password", $hashedPwd);
  $stmt->bindParam(":email", $email);
  $stmt->execute();
}

function createUser(object $pdo, string $username, string  $password, string  $email)
{
  setUser($pdo, $username, $password, $email);
}


/* function Login */
function getUsernameLogin(object $pdo, string $username)
{
  $query = "SELECT * FROM users WHERE username = :username;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":username", $username);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function isUsernameWrong(bool | array $result)
{
  if (!$result) { //jika username tidak ada di database
    return true;
  } else {
    return false;
  }
}

function isPassWrong(string $pwd, string $hashedPwd)
{
  if (!password_verify($pwd, $hashedPwd)) {
    return true;
  } else {
    return false;
  }
}

function isInputEmptyLogin(string $username, string  $password)
{
  if (empty($username) || empty($password)) {
    return true;
  } else {
    return false;
  }
}

function checkLoginError()
{
  if ($_SESSION["error"]) {
    $errors = $_SESSION["error"];

    echo "<br>";

    foreach ($errors as $error) {
      echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }

    unset($_SESSION["error"]);
  }
}
