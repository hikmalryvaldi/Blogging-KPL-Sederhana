<?php

require_once "../includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $article_id = $_POST["article_id"];
    $username = $_POST["username"];
    $comment_text = $_POST["comment_text"];

    $query = "INSERT INTO comments (article_id, username, comment_text, created_at) VALUES (:article_id, :username, :comment_text, NOW())";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: ../artikel/view.php?id=" . $article_id);
    exit();
} else {
    die("Metode pengiriman tidak valid!");
}
