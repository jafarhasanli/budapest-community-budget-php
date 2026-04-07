<?php
require_once "auth.php";
require_once "storage.php";
require_login();

$projects = new Storage(new JsonIO("projects.json"));

$title = trim($_POST['title']);
$desc  = trim($_POST['description']);
$postal = trim($_POST['postal']);
$image  = trim($_POST['image']);

/* VALIDATIONS */
if (strlen($title) < 10) die("Title too short");
if (strlen($desc) < 150) die("Description too short");

/* Postal code validation */
if (
  !preg_match('/^1(0[1-9]|1[0-9]|2[0-3])[1-9]$/', $postal)
  && $postal !== '1007'
) {
  die("Invalid Budapest postal code");
}

/* Image URL validation */
if ($image !== '' && !filter_var($image, FILTER_VALIDATE_URL)) {
  die("Invalid image URL");
}

if (isset($_POST['id'])) {
  /* UPDATE (REWORK) */
  $p = $projects->findById($_POST['id']);
  if (!$p || $p['owner'] !== $_SESSION['user']['username']) {
    die("Forbidden");
  }

  $p['title'] = $title;
  $p['description'] = $desc;
  $p['category'] = $_POST['category'];
  $p['postal'] = $postal;
  $p['image'] = $image;
  $p['status'] = 'pending';

  $projects->update($p['id'], $p);
} else {
  /* NEW PROJECT */
  $projects->add([
    'title' => $title,
    'description' => $desc,
    'category' => $_POST['category'],
    'postal' => $postal,
    'image' => $image,
    'owner' => $_SESSION['user']['username'],
    'status' => 'pending',
    'submitted' => date("Y-m-d H:i"),
    'approved' => null
  ]);
}

header("Location: projects-own.php");
exit;
