<?php
require_once 'public/init.php';

$user = new User($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

if(isset($_POST['update'])) {
  if(empty($_POST['name']) || empty($_POST['username']) || empty($_POST['email'])) {
    $error = "Fill in all fields";
  } else {
    $user->name = $_POST['name'];
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];

    if($user->updateUser()) {
      $_SESSION['username'] = $user->username;
      
      header("Location: " . BASE_URL . "/home.php");
    } else {
      $error = "Unable to update profile";
    }
  }
}

if(isset($_POST['change_password'])) {
  if(empty($_POST['confirm_password']) || empty($_POST['new_password']) || empty($_POST['confirm_new_password'])) {
    $password_error = "Fill in all fields";
  } else {
    if($_POST['new_password'] != $_POST['confirm_new_password']) {
      $password_error = "Passwords must match";
    } else {
      $user->confirm_password = $_POST['confirm_password'];
      $user->new_password = $_POST['new_password'];
  
      if(password_verify($user->confirm_password, $user_data['password'])) {
        if($user->changePassword()) {
          header("Location: " . BASE_URL . "/home.php");
        } else {
          $password_error = "Unable to change password";
        }
      } else {
        $password_error = "Enter current password correctly";
      }
    }
  }
}

require VIEW_ROOT . '/update.php';