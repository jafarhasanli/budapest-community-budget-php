<?php
require_once "storage.php";
session_start();

$users = new Storage(new JsonIO("users.json"));
$user = $users->findOne(['username' => $_POST['username']]);

if ($user && password_verify($_POST['password'], $user['password'])) {
  $_SESSION['user'] = $user;
  header("Location: index.php");
  exit;
}
die("Login failed");
