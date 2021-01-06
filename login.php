<?php
require_once "init.php";

if(isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = :username LIMIT 0,1";
  $stmt = $db->prepare($query);
  $stmt->execute([
    "username" => $username
  ]);

  $rows = $stmt->rowCount();

  if($rows > 0) {
    $row = $stmt->fetch();

    if(password_verify($password, $row['password'])) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['logged_in'] = true;

      header("Location: home.php");
    } else {
      echo("<p>Username or Password Incorrect</p>");
    }
  } else {
    echo("<p>Username or Password Incorrect</p>");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user-account</title>
</head>
<body>
  <div class="container">
    <h1>user-account</h1>

    <div class="form">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <input type="text" name="username" placeholder="Username">
      </div>
      <div class="form-group">
        <input type="password" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <input type="submit" name="login" value="Log In">
      </div>
    </div>
  </div>
</body>
</html>