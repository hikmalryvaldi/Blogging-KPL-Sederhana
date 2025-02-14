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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php require_once "../includes/header.inc.php"; ?>
  <div class="container my-5">
    <h2 class="mb-5 text-center">All Article</h2>
    <div class="row g-4">
      <?php foreach ($result as $data): ?>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <img src="../assets/img/<?= $data["gambar"]; ?>" class="card-img-top" alt="" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="view.php?id=<?= $data["id"] ?>" class="text-decoration-none text-dark">
                  <?= htmlspecialchars($data["judul"]); ?>
                </a>
              </h5>
              <p class="card-text text-truncate"><?= htmlspecialchars($data["artikel_text"]); ?></p>
            </div>
            <div class="card-footer bg-white border-0">
              <small class="text-muted"><?= htmlspecialchars($data["created_at"]); ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php require_once "../includes/footer.inc.php"; ?>
</body>

</html>