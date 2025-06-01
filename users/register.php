<?php
session_start();
require_once "../includes/function.php";


if (empty($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$token = $_SESSION["csrf_token"];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php require_once "../includes/header.inc.php"; ?>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">

        <?php if (isset($_SESSION["error"])) {
          checkSignUpError();
        } ?>

        <div class="card">
          <div class="card-header text-center">
            <h4>Register</h4>
          </div>
          <div class="card-body">
            <form action="../includes/signup.inc.php" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="username">
              </div>
              <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="password">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="email">
              </div>
              <button type="submit" class="btn btn-white border w-100">Register</button>
            </form>
          </div>
          <div class="card-footer text-center ">
            <a href="login.php" class="link-secondary link-underline-opacity-0">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>