<?php
session_start();
include 'dbh.inc.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Mengambil input dari form dengan name="password"

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND pwd = :pwd");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pwd', $password); // Bind parameter :pwd dengan nilai $password
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['username'] = $username;
            header("Location: ../index.php"); // ganti dengan halaman tujuan setelah login sukses
        } else {
            echo "Login gagal, username atau password salah.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
