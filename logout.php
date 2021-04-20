<?php
require_once 'public/init.php';

$user = new User($db);

$user->logOut();

header("Location: " . BASE_URL);