<?php

require_once "../includes/dbh.inc.php";

$query = "SELECT * FROM articles";

$stmt = $pdo->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article</title>
</head>

<body>

  <?php foreach ($result as $data): ?>
    <p><?= $data["id"]; ?></p>
    <a href="view.php?id=<?= $data["id"] ?>"><?= htmlspecialchars($data["judul"]); ?></a>
    <p><?= htmlspecialchars($data["artikel_text"]); ?></p>
    <p><?= htmlspecialchars($data["penulis"]); ?></p>
    <p><?= htmlspecialchars($data["created_at"]); ?></p>
    <hr>
  <?php endforeach; ?>

  <!-- komentar -->

</body>

</html>