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
    <a href=""><?= $data["judul"]; ?></a>
    <p><?= $data["artikel_text"]; ?></p>
    <p><?= $data["penulis"]; ?></p>
    <p><?= $data["created_at"]; ?></p>
    <hr>
  <?php endforeach; ?>

</body>

</html>