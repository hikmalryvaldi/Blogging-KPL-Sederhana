<?php

require_once "../includes/dbh.inc.php";
include_once "log_helper.php"; // Logging helper

session_start();

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

// Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifikasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        write_log("Gagal menambah komentar: CSRF token tidak valid (user: " . ($_POST['username'] ?? 'unknown') . ")", 'ERROR');
        die("CSRF token tidak valid!");
    }

    // Ambil data dari form
    $article_id = $_POST["article_id"];
    $username = $_POST["username"];
    $comment_text = $_POST["comment_text"];

    // Validasi inputan
    if (empty($article_id) || !is_numeric($article_id)) {
        write_log("Gagal menambah komentar: Artikel ID tidak valid (user: $username)", 'ERROR');
        die("Artikel ID tidak valid.");
    }

    if (empty($username) || strlen($username) < 3) {
        write_log("Gagal menambah komentar: Nama pengguna tidak valid (username: $username)", 'ERROR');
        die("Nama pengguna tidak valid.");
    }

    if (empty($comment_text) || strlen($comment_text) < 5) {
        write_log("Gagal menambah komentar: Komentar terlalu pendek (user: $username)", 'ERROR');
        die("Komentar terlalu pendek.");
    }

    try {
        // Query untuk insert komentar ke database
        $query = "INSERT INTO comments (article_id, username, comment_text, created_at) VALUES (:article_id, :username, :comment_text, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
        $stmt->execute();

        write_log("User '$username' berhasil menambah komentar di artikel ID $article_id", 'INFO');

        // Redirect ke halaman artikel setelah komentar berhasil ditambahkan
        header("Location: ../artikel/view.php?id=" . $article_id);
        exit();
    } catch (PDOException $e) {
        write_log("PDO Exception saat tambah komentar: " . $e->getMessage() . " (user: $username)", 'ERROR');
        die("Query GAGAL: " . $e->getMessage());
    }
} else {
    write_log("Gagal menambah komentar: Metode pengiriman tidak valid", 'ERROR');
    die("Metode pengiriman tidak valid!");
}
