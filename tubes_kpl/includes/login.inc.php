<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; // hikmal
    $password = $_POST["password"]; // 123

    try {
        require_once "dbh.inc.php";
        require_once "function.php";

        $error = [];

        if (isInputEmptyLogin($username, password: $password)) {
            $error["empty_input"] = "Tolong masukkan input yang kosong";
        }

        $result = getUsernameLogin($pdo, $username); // array assosiatif

        if (isUsernameWrong($result)) {
            $error["login_incorrect"] = "Username salah atau kosong";
        }

        if (!isUsernameWrong($result) && isPassWrong($password, $result["pwd"])) {
            $error["login_incorrect"] = "Password salah";
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
