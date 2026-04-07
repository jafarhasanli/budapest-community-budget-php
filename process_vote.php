<?php
require_once "auth.php";
require_once "storage.php";
require_login();

$votes = new Storage(new JsonIO("votes.json"));
$projects = new Storage(new JsonIO("projects.json"));

$user = $_SESSION['user']['username'];
$projectId = $_POST['project'];
$action = $_POST['action'];

$project = $projects->findById($projectId);
if (!$project || $project['status'] !== 'approved') {
  echo json_encode(['error'=>'Invalid project']); exit;
}

/* ⏱️ 2 weeks rule */
$approved = strtotime($project['approved']);
if (time() - $approved > 60*60*24*14) {
  echo json_encode(['error'=>'Voting closed']); exit;
}

/* all user votes */
$userVotes = $votes->findAll(['user'=>$user]);

/* category votes count */
$catVotes = array_filter($userVotes, fn($v)=>$v['category']===$project['category']);

/* already voted? */
$already = $votes->findOne(['user'=>$user,'project'=>$projectId]);

if ($action==='add') {
  if ($already) { echo json_encode(['error'=>'Already voted']); exit; }
  if (count($catVotes)>=3) { echo json_encode(['error'=>'Limit reached']); exit; }

  $votes->add([
    'user'=>$user,
    'project'=>$projectId,
    'category'=>$project['category'],
    'time'=>date("Y-m-d H:i")
  ]);
}

if ($action==='remove') {
  if ($already) $votes->delete($already['id']);
}

echo json_encode(['success'=>true]);
