<?php
require_once "init.php";

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([
  "id" => $id
]);

$user_data = $stmt->fetch();

if(isset($_POST['update'])) {
  $name = htmlentities($_POST['name']);
  $username = htmlentities($_POST['username']);
  $email = htmlentities($_POST['email']);

  $query = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->execute([
    "id" => $id,
    "name" => $name,
    "username" => $username,
    "email" => $email
  ]);

  header("Location: home.php");
}

if(isset($_POST['change_password'])) {
  $confirm_password = $_POST['confirm_password'];
  $new_password = $_POST['new_password'];
  $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

  if(password_verify($confirm_password, $user_data['password'])) {
    $query = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([
      "id" => $id,
      "password" => $new_hashed_password
    ]);

    header("Location: home.php");
  } else {
    echo("<p>Enter your current password correctly</p>");
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

    <h3>Update Profile</h3>

    <div class="form">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <input type="text" name="name" value="<?php echo $user_data['name']; ?>">
        </div>
        <div class="form-group">
          <input type="text" name="username" value="<?php echo $user_data['username']; ?>">
        </div>
        <div class="form-group">
          <input type="text" name="email" value="<?php echo $user_data['email']; ?>">
        </div>
        <div class="form-group">
          <input type="submit" name="update" value="Update">
        </div>
      </form>
    </div>
    <div class="form">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <p>Change Password</p>
        </div>
        <div class="form-group">
          <input type="password" name="confirm_password" placeholder="Confirm Password">
        </div>
        <div class="form-group">
          <input type="password" name="new_password" placeholder="New Password">
        </div>
        <div class="form-group">
          <input type="submit" name="change_password" value="Change Password">
        </div>
      </form>
    </div>
  </div>
</body>
</html>