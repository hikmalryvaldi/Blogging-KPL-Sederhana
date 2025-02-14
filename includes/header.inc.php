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
      background-color: #d0ebff;
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

    .navbar a:hover {
      background-color: #a0d3ff;
      color: #fff;
    }

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
<body>
  <nav class="navbar">
    <div class="left-section">
      <a href="index.php" class="logo-link">
        <img src="assets/img/contoh logo.png" alt="Logo" class="logo">
      </a>
      <a href="artikel/list.php">List Artikel</a>
    </div>
    <div class="right-section">
      <?php if (isset($_SESSION['username'])): ?>
        <a href="users/logout.php">Logout</a>
      <?php else: ?>
        <a href="users/login.php">Login</a>
      <?php endif; ?>
    </div>
  </nav>
</body>
