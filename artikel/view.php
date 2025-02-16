<?php

require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";
if (!isset($_SESSION["user_id"])) {
  header("Location: ../users/login.php"); // Redirect ke halaman login jika belum login
  exit();
}

// Mendefinisikan variabel $id dengan nilai dari parameter URL
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $queryArticle = "SELECT * FROM articles WHERE id = :id";
  $queryComments = "SELECT * FROM comments WHERE article_id = :id ORDER BY created_at DESC";

  $stmtArticle = $pdo->prepare($queryArticle);
  $stmtArticle->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtArticle->execute();

  $stmtComments = $pdo->prepare($queryComments);
  $stmtComments->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtComments->execute();

  $resultArticle = $stmtArticle->fetch(PDO::FETCH_ASSOC);
  $resultComments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
} else {
  die("ID artikel tidak disediakan!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artikel</title>
</head>

<body>

  <img style="width: 300px;" src="../assets/img/<?= $resultArticle["gambar"]; ?>" alt="">
  <h4><?= htmlspecialchars($resultArticle["judul"]); ?></h4>
  <p><?= htmlspecialchars($resultArticle["artikel_text"]); ?></p>
  <p><?= htmlspecialchars($resultArticle["penulis"]); ?></p>
  <p><?= htmlspecialchars($resultArticle["created_at"]); ?></p>
  <a href="edit.php?id=<?= $resultArticle["id"] ?>">Edit</a>
  <a href="riwayat_penerbitan.php?id=<?= $resultArticle["id"] ?>">Riwayat</a>

  <hr>

  <h4>Komentar</h4>
  <?php foreach ($resultComments as $comment): ?>
    <p><strong><?= htmlspecialchars($comment["username"]); ?></strong> (<?= htmlspecialchars($comment["created_at"]); ?>)</p>
    <p><?= htmlspecialchars($comment["comment_text"]); ?></p>
    <hr>
  <?php endforeach; ?>

  <form action="../includes/add_comment.inc.php" method="post">
    <input type="hidden" name="article_id" value="<?= $id ?>">
    <input type="text" name="username" placeholder="Nama Anda">
    <textarea name="comment_text" placeholder="Komentar Anda"></textarea>
    <button type="submit">Tambahkan Komentar</button>
  </form>

</body>

</html>