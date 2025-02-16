<?php
require_once "includes/config_session.inc.php";
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
  <header>
    <h2>Blogging KPL</h2>
    <nav>
      <?php if (isset($_SESSION['user_id'])) : ?>
        <!-- Jika sudah login -->
        <a href="artikel/list.php">List Artikel</a>
        <a href="artikel/tambah.php">Tambah Artikel</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="includes/logout.inc.php" method="post" style="display: none;">
        </form>
      <?php else : ?>
        <!-- Jika belum login -->
        <a href="users/login.php">Login</a>
        <a href="users/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </header>
  <div class="container">
    <div class="page">
      <h1>Article</h1>

      <?php if (!empty($result)) : ?>
        <div class="card-1">
          <a href="artikel/view.php?id=<?= $result[0]["id"] ?>">
            <img src="assets/img/<?= $result[0]["gambar"]; ?>" alt="">
          </a>
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
            <a href="artikel/view.php?id=<?= $data["id"] ?>">
              <img src="assets/img/<?= $data["gambar"]; ?>" alt="">
            </a>
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
