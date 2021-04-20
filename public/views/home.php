<?php require_once 'includes/header.php'; ?>

<div class="container">
  <h1>user-account</h1>
  <p>Welcome <?php echo $user_data['name']; ?></p>
  <p><a href="<?php echo BASE_URL; ?>/update.php?id=<?php echo $user_data['id']; ?>">Update profile</a></p>
  <p><a href="<?php echo BASE_URL; ?>/delete.php?id=<?php echo $user_data['id']; ?>">Delete account</a></p>
  <p><a href="<?php echo BASE_URL; ?>/logout.php">Log out</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>