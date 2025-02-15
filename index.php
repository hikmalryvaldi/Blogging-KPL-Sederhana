<?php

require_once "includes/dbh.inc.php";

$query = "SELECT * FROM articles WHERE aksi = 'public' ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blogging KPL</title>
  <link rel="stylesheet" href="assets/css/index-style.css">
</head>

<body>
  <div class="container">
    <div class="page">
      <h1>Blogging KPL</h1>

      <?php if (!empty($result)) : ?>
        <div class="card-1">
          <img src="assets/img/<?= $result[0]["gambar"]; ?>" alt="">
          <div class="artikel">
            <a href="artikel/view.php?id=<?= $result[0]["id"] ?>">
              <?= htmlspecialchars($result[0]["judul"]); ?>
            </a>
            <p><em><?= date("F d, Y", strtotime($result[0]["created_at"])); ?></em></p>
          </div>
        </div>
      <?php endif; ?>

      <div class="card-content">
        <?php foreach (array_slice($result, 1) as $data) : ?>
          <div class="cards">
            <img src="assets/img/<?= $data["gambar"]; ?>" alt="">
            <div class="artikel">
              <a href="artikel/view.php?id=<?= $data["id"] ?>">
                <?= htmlspecialchars($data["judul"]); ?>
              </a>
              <p><em><?= date("F d, Y", strtotime($data["created_at"])); ?></em></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

</body>

</html>