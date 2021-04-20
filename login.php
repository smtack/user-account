<?php
require_once 'public/init.php';

if(isset($_POST['login'])) {
  if(empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Fill in username and password";
  } else {
    $user = new User($db);

    $user->username = $_POST['username'];
  
    $logIn = $user->logIn();
  
    if($logIn && password_verify($_POST['password'], $user->password)) {
      $_SESSION['username'] = $user->username;
      $_SESSION['logged_in'] = true;
  
      header("Location: " . BASE_URL . "/home.php");
    } else {
      $error = "Username or Password Incorrect";
    }
  }
}

require VIEW_ROOT . '/login.php';