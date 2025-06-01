<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";

if (isset($_SESSION["user_id"])) {
  $userId = $_SESSION["user_id"];
  $query = "SELECT * FROM users WHERE id = :user_id";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam("user_id", $userId);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  // echo $user["username"];
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

if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // Buat token CSRF baru
}

// Ambil token CSRF untuk digunakan di form
$csrf_token = $_SESSION["csrf_token"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artikel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php require_once "../includes/header.inc.php"; ?>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-10 px-4">
        <div class="mb-4">
          <div class="text-center mb-4">
            <img src="../assets/img/<?= $resultArticle["gambar"]; ?>" class="img-fluid" alt="" style="max-width: 100%; max-height: 400px; object-fit: contain;">
          </div>

          <div class="mb-4">
            <h4 class="mb-3"><?= htmlspecialchars($resultArticle["judul"]); ?></h4>
            <p class="mb-4"><?= htmlspecialchars($resultArticle["artikel_text"]); ?></p>

            <?php if (isset($user)): ?>
              <?php if ($user["id"] == $resultArticle["users_id"]): ?>
                <div class="text-muted mb-4">
                  <?= htmlspecialchars($resultArticle["penulis"]); ?> | <?= htmlspecialchars($resultArticle["created_at"]); ?>
                </div>

                <div>
                  <a href="edit.php?id=<?= $resultArticle["id"] ?>" class="btn btn-primary me-2">Edit</a>
                  <a href="riwayat_penerbitan.php?id=<?= $resultArticle["id"] ?>" class="btn btn-info">Riwayat</a>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-10 px-4">
        <h4 class="mb-4">Komentar</h4>
        <hr>

        <div class="mb-5">
          <?php foreach ($resultComments as $comment): ?>
            <div class="mb-4">
              <div class="d-flex gap-2 align-items-center mb-2">
                <p><strong><?= htmlspecialchars($comment["username"]); ?></strong> (<?= htmlspecialchars($comment["created_at"]); ?>)</p>
              </div>
              <p class="mb-3"><?= htmlspecialchars($comment["comment_text"]); ?></p>
              <hr>
            </div>
          <?php endforeach; ?>
        </div>

        <form action="../includes/add_comment.inc.php" method="post" class="mb-5">
          <input type="hidden" name="article_id" value="<?= $id ?>">
          <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">

          <div class="mb-3">
            <?php if (isset($_SESSION["user_id"])): ?>
              <input type="text" name="username" class="form-control" value="<?= $user["username"] ?>" placeholder="Nama Anda">
            <?php else: ?>
              <input type="text" name="username" class="form-control" placeholder="Nama Anda">
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <textarea name="comment_text" class="form-control" rows="4" placeholder="Komentar Anda"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Tambahkan Komentar</button>
        </form>
      </div>
    </div>
  </div>
  <?php require_once "../includes/footer.inc.php"; ?>
</body>

</html>