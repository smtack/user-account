<?php
require_once "init.php";

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute(["id" => $id]);

header("Location: index.php");
?>