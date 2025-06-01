<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .navbar {
    width: 100%;
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* background-color: #fff; */
    padding: 0 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .navbar a {
    text-decoration: none;
    color: #000;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-weight: 500;
  }

  /* .navbar a:hover {
    background-color: #a0d3ff;
    color: #fff;
  } */

  .navbar a.logo-link:hover {
    background-color: transparent;
  }

  .navbar .logo {
    height: 50px;
    margin-right: 5px;
  }

  .navbar .left-section {
    display: flex;
    align-items: center;
  }

  .navbar .right-section {
    display: flex;
    gap: 10px;
  }
</style>
</head>

<?php

// Jika token belum ada di session, buat token baru
if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32)); // Buat token CSRF baru
}

// Ambil token CSRF untuk digunakan di form
$csrf_token = $_SESSION["csrf_token"];
?>

<body>
  <nav class="navbar">
    <div class="left-section">
      <a href="../index.php" class="logo-link">
        Blogging KPL
      </a>
    </div>
    <div class="right-section">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="../includes/logout.inc.php" method="post" style="display: none;">
          <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
        </form>
      <?php endif; ?>
    </div>
  </nav>
</body>