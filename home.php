<?php
require_once 'public/init.php';

$user = new User($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

require VIEW_ROOT . '/home.php';