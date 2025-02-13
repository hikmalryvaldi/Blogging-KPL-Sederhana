<?php

require_once "../includes/dbh.inc.php";

$query = "SELECT * FROM articles ORDER BY created_at DESC";

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
    <div>
      <img src="../assets/img/<?= $data["gambar"]; ?>" alt="">
      <div>
        <a href="view.php?id=<?= $data["id"] ?>"><?= htmlspecialchars($data["judul"]); ?></a>
        <p><?= htmlspecialchars($data["artikel_text"]); ?></p>
        <p><?= htmlspecialchars($data["created_at"]); ?></p>
      </div>
    </div>
    <hr>
  <?php endforeach; ?>

</body>

</html>