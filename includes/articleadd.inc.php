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



// Validasi CSRF token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        write_log("Tambah artikel gagal: CSRF token tidak valid (user_id: {$_SESSION['user_id']})", 'ERROR');
        die("❌ CSRF token tidak valid!");
    }

    // Validasi input
    $penulis = trim($_POST["penulis"]);
    $judul = trim($_POST["judul"]);
    $isi = trim($_POST["artikel_text"]);
    $id = $_SESSION["user_id"];

    if (empty($penulis) || empty($judul) || empty($isi)) {
        $_SESSION["error"] = "Semua field harus diisi!";
        write_log("Tambah artikel gagal: Field kosong (user_id: $id)", 'ERROR');
        header("Location: ../artikel/tambah.php");
        exit();
    }

    // Validasi file upload
    $gambar = $_FILES["gambar"]["name"];
    $tmpName = $_FILES["gambar"]["tmp_name"];
    $maxSize = 10 * 1024 * 1024; // 10MB
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!empty($gambar)) {
        if ($_FILES["gambar"]["size"] > $maxSize) {
            $_SESSION["error"] = "Ukuran file terlalu besar. Maksimal ukuran yang diizinkan adalah 10MB.";
            write_log("Tambah artikel gagal: Ukuran file gambar terlalu besar (user_id: $id)", 'ERROR');
            header("Location: ../artikel/tambah.php");
            exit();
        }

        if (!in_array($_FILES["gambar"]["type"], $allowedTypes)) {
            $_SESSION["error"] = "Jenis file tidak diizinkan. Hanya file JPG, PNG, dan GIF yang diizinkan.";
            write_log("Tambah artikel gagal: Jenis file gambar tidak valid (user_id: $id)", 'ERROR');
            header("Location: ../artikel/tambah.php");
            exit();
        }

        // Generate nama file unik
        $gambar = uniqid() . "_" . basename($gambar);
        $folder = "../assets/img/" . $gambar;
    } else {
        $_SESSION["error"] = "File gambar harus diunggah.";
        write_log("Tambah artikel gagal: File gambar tidak diunggah (user_id: $id)", 'ERROR');
        header("Location: ../artikel/tambah.php");
        exit();
    }

    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO articles (penulis, judul, gambar, artikel_text, users_id) VALUES (:penulis, :judul, :gambar, :isi, :user_id);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":penulis", $penulis);
        $stmt->bindParam(":judul", $judul);
        $stmt->bindParam(":gambar", $gambar);
        $stmt->bindParam(":isi", $isi);
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();

        move_uploaded_file($tmpName, $folder);

        write_log("User '$penulis' (user_id: $id) berhasil membuat artikel baru dengan judul '$judul'", 'INFO');

        $_SESSION["success"] = "Artikel berhasil dibuat!";
        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Terjadi kesalahan saat membuat artikel: " . $e->getMessage();
        write_log("Tambah artikel gagal: " . $e->getMessage() . " (user_id: $id)", 'ERROR');
        header("Location: ../artikel/tambah.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
