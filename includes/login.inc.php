<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require_once "dbh.inc.php";
        require_once "function.php";

        $error = [];

        if (isInputEmptyLogin($username, $password)) {
            $error["empty_input"] = "Tolong masukkan input yang kosong";
        }

        $result = getUsernameLogin($pdo, $username);

        if (isUsernameWrong($result)) {
            $error["login_incorrect"] = "Login Gagal";
        }
        if (!isUsernameWrong($result) && isPassWrong($password, $result["pwd"])) {
            $error["login_incorrect"] = "Login Gagal";
        }

        require_once "config_session.inc.php";

        if ($error) {
            $_SESSION["error"] = $error;
            header("Location: ../users/login.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["last_generation"] = time();

        header("Location: ../index.php");

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

// if (isset($_POST['username']) && isset($_POST['password'])) {
//     $username = $_POST['username'];
//     $password = $_POST['password']; // Mengambil input dari form dengan name="password"

//     try {
//         $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND pwd = :pwd");
//         $stmt->bindParam(':username', $username);
//         $stmt->bindParam(':pwd', $password); // Bind parameter :pwd dengan nilai $password
//         $stmt->execute();

//         if ($stmt->rowCount() > 0) {
//             $_SESSION['username'] = $username;
//             header("Location: ../index.php"); // ganti dengan halaman tujuan setelah login sukses
//         } else {
//             echo "Login gagal, username atau password salah.";
//         }
//     } catch (PDOException $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }
