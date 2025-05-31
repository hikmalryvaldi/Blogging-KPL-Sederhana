<?php
session_start();
require_once "../includes/function.php";

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION["csrf_token"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- reCaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php require_once "../includes/header.inc.php"; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- alert berhasil jika register success -->
                <?php if (isset($_GET["signup"]) && $_GET["signup"] === "success"): ?>
                    <br>
                    <!-- <p></p> -->
                    <div id="notif" class="alert alert-info" role="alert">
                        Register berhasil, silakan login
                    </div>
                    <script>
                        setTimeout(() => {
                            document.getElementById("notif").style.display = "none";
                        }, 3000);
                    </script>
                <?php endif; ?>

                <!-- alert error yang sudah di looping pada function checkLoginError -->
                <?php if (isset($_SESSION["error"]))
                    checkLoginError();
                ?>

                <!-- card login -->
                <div class="card mt-5">
                    <!-- header -->
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>

                    <!-- form login -->
                    <div class="card-body">
                        <form action="../includes/login.inc.php" method="POST">
                            <!-- username -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <!-- reCaptcha -->
                            <div class="g-recaptcha" data-sitekey="6Lfk_FArAAAAAHKx2yIQBUz81w7esqqxt1lFMYK3"></div>
                            <p class="captcha text-danger"></p>

                            <!-- hidden token csrf  -->
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <button type="submit" class="btn btn-white border btn-block login">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="register.php" class="text-secondary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>