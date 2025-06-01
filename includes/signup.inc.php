<?php
session_start();
include_once "log_helper.php"; // Logging helper

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        write_log("Percobaan signup gagal: CSRF token tidak valid", 'ERROR');
        die("CSRF token tidak valid!");
    }

    unset($_SESSION["csrf_token"]);

    $username = trim($_POST["username"]);
    $password = $_POST["pwd"];
    $email = trim($_POST["email"]);
    $token = bin2hex(random_bytes(32));

    try {
        require_once "dbh.inc.php";
        require_once "function.php";

        $error = [];

        if (isInputEmpty($username, $password, $email)) {
            $error["empty_input"] = "Tolong masukkan input yang kosong";
            write_log("Signup gagal: input kosong (username/email/password)", 'ERROR');
        }
        if (isEmailInvalid($email)) {
            $error["email_invalid"] = "Email yang anda masukkan tidak valid";
            write_log("Signup gagal: email tidak valid - $email", 'ERROR');
        }
        if (isNameTaken($pdo, $username)) {
            $error["username_taken"] = "Username yang anda masukkan sudah ada";
            write_log("Signup gagal: username '$username' sudah digunakan", 'ERROR');
        }
        if (isEmailTaken($pdo, $email)) {
            $error["email_taken"] = "Email yang anda masukkan sudah ada";
            write_log("Signup gagal: email '$email' sudah digunakan", 'ERROR');
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

        write_log("User '$username' berhasil melakukan signup dengan email '$email'", 'INFO');

        header("Location: ../users/login.php?signup=success");
        exit();
    } catch (PDOException $e) {
        write_log("PDO Exception saat signup: " . $e->getMessage(), 'ERROR');
        die("Query GAGAL: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
