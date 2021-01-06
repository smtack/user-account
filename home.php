<?php
require_once "init.php";

$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->execute([
  "username" => $username,
]);

$user_data = $stmt->fetch();
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
    <p>Welcome <?php echo $user_data['name']; ?></p>
    <p><a href="update.php?id=<?php echo $user_data['id']; ?>">Update profile</a></p>
    <p><a href="delete.php?id=<?php echo $user_data['id']; ?>">Delete account</a></p>
    <p><a href="logout.php">Log out</a></p>
  </div>
</body>
</html>