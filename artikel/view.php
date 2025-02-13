<?php
$id = $_GET["id"];
require_once "../includes/dbh.inc.php";

$query = "SELECT * FROM articles WHERE id = $id";

$stmt = $pdo->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>artikel</title>
</head>

<body>

  <h4><?= htmlspecialchars($result[0]["judul"]); ?></h4>
  <p><?= htmlspecialchars($result[0]["artikel_text"]); ?></p>
  <p><?= htmlspecialchars($result[0]["penulis"]); ?></p>
  <p><?= htmlspecialchars($result[0]["created_at"]); ?></p>

</body>

</html>