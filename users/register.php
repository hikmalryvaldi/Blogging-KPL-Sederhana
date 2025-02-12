<!-- tinggal di style -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>

  <form action="../includes/formhandler.inc.php" method="post">
    <label for="username">username:</label>
    <input type="text" name="username" placeholder="username...">

    <label for="pwd">password:</label>
    <input type="password" name="pwd" placeholder="password...">

    <label for="email">email:</label>
    <input type="text" name="email" placeholder="email...">

    <button type="submit">Register</button>
  </form>

</body>

</html>