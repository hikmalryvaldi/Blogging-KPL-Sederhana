<?php
session_start();
include_once "log_helper.php"; // Tambahkan logging helper

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

// Buat CSRF token jika belum ada
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        write_log("Percobaan logout gagal: CSRF token tidak valid", 'ERROR');
        die("❌ CSRF token tidak valid!");
    }

    // Ambil username dulu sebelum session dihapus
    $username = $_SESSION["user_username"] ?? 'unknown';

    session_unset();
    session_destroy();

    write_log("User '$username' berhasil logout", 'INFO');

    header("Location: ../index.php");
    exit();
}
