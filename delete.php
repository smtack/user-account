<?php
require_once 'public/init.php';

$user = new User($db);

if($user->deleteUser()) {
  header("Location: " . BASE_URL);
} else {
  header("Location: " . BASE_URL . "/home.php");
}