<?php
require_once "init.php";

if(isset($_POST['signup'])) {
  if(empty($_POST['name']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    echo("<p>Please fill all fields</p>");
  } else {
    $name = htmlentities($_POST['name']);
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password != $confirm_password) {
      echo("<p>Passwords do not match</p>");
    } else {
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      $query = "INSERT INTO users (name, username, email, password) VALUES (:name, :username, :email, :password)";
      $stmt = $db->prepare($query);
      $stmt->execute([
        "name" => $name,
        "username" => $username,
        "email" => $email,
        "password" => $hashed_password
      ]);
      
      $_SESSION['username'] = $username;
      $_SESSION['logged_in'] = true;
    
      header("Location: home.php");
    }
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
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <input type="text" name="name" placeholder="Name">
        </div>
        <div class="form-group">
          <input type="text" name="username" placeholder="Username">
        </div>
        <div class="form-group">
          <input type="text" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <input type="password" name="confirm_password" placeholder="Confirm Password">
        </div>
        <div class="form-group">
          <input type="submit" name="signup" value="Sign Up">
        </div>
        <div class="form-group">
          <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>