<?php
session_start();
include_once "log_helper.php"; // Tambahkan ini

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
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";
        require_once "function.php";

        $error = [];

        if (isInputEmptyLogin($username, password: $password)) {
            $error["empty_input"] = "Tolong masukkan input yang kosong";
            write_log("Percobaan login gagal: input kosong", 'ERROR');
        }

        $result = getUsernameLogin($pdo, $username); // hasil array assoc

        if (isUsernameWrong($result)) {
            $error["login_incorrect"] = "Username salah atau kosong";
            write_log("Percobaan login gagal: username '$username' tidak ditemukan", 'ERROR');
        }

        if (!isUsernameWrong($result) && isPassWrong($password, $result["pwd"])) {
            $error["login_incorrect"] = "Password salah";
            write_log("Percobaan login gagal: password salah untuk user '$username'", 'ERROR');
        }

        require_once "config_session.inc.php";

        if ($error) {
            $_SESSION["error"] = $error;
            header("Location: ../users/login.php");
            die();
        }

        // Login berhasil
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["last_generation"] = time();

        write_log("User '{$result["username"]}' berhasil login", 'INFO');

        header("Location: ../index.php");

        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        write_log("PDO Exception saat login: " . $e->getMessage(), 'ERROR');
        die("Query GAGAL: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
