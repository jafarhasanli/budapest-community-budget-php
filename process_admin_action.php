<?php
require_once "auth.php";
require_once "storage.php";
require_admin();

$projects = new Storage(new JsonIO("projects.json"));
$p = $projects->findById($_GET['id']);

if (!$p) die("Not found");

if ($_GET['a']=='approve') {
  $p['status']='approved';
  $p['approved']=date("Y-m-d H:i");
}
elseif ($_GET['a']=='reject') {
  $p['status']='rejected';
}
elseif ($_GET['a']=='rework') {
  $p['status']='rework';
}

$projects->update($p['id'], $p);
header("Location: projects-admin.php");
