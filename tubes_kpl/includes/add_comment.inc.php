<?php

require_once "../includes/dbh.inc.php";

// Mulai session untuk CSRF token
session_start();

// Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate token jika belum ada
}

// Validasi form saat POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifikasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token tidak valid!");
    }

    // Ambil data dari form
    $article_id = $_POST["article_id"];
    $username = $_POST["username"];
    $comment_text = $_POST["comment_text"];

    // Validasi inputan
    if (empty($article_id) || !is_numeric($article_id)) {
        die("Artikel ID tidak valid.");
    }

    if (empty($username) || strlen($username) < 3) {
        die("Nama pengguna tidak valid.");
    }

    if (empty($comment_text) || strlen($comment_text) < 5) {
        die("Komentar terlalu pendek.");
    }

    // Query untuk insert komentar ke database
    $query = "INSERT INTO comments (article_id, username, comment_text, created_at) VALUES (:article_id, :username, :comment_text, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect ke halaman artikel setelah komentar berhasil ditambahkan
    header("Location: ../artikel/view.php?id=" . $article_id);
    exit();
} else {
    die("Metode pengiriman tidak valid!");
}
