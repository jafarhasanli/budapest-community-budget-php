<?php
require_once "storage.php";

$users = new Storage(new JsonIO("users.json"));

$username = trim($_POST['username']);
$email = $_POST['email'];
$p1 = $_POST['password'];
$p2 = $_POST['password2'];

if (strpos($username,' ')!==false) die("Invalid username");
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) die("Invalid email");
if ($p1!==$p2) die("Passwords mismatch");
if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}/',$p1)) die("Weak password");

if ($users->findOne(['username'=>$username])) die("Exists");

$users->add([
  'username'=>$username,
  'email'=>$email,
  'password'=>password_hash($p1,PASSWORD_DEFAULT),
  'is_admin'=>false
]);

header("Location: login.php");
