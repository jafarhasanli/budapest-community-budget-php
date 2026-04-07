<?php
require_once "auth.php";
require_login();
require_once "storage.php";
include "menu.php";

$projects = new Storage(new JsonIO("projects.json"));
$username = $_SESSION['user']['username'];

$userProjects = $projects->findAll(['owner' => $username]);
?>

<div class="max-w-5xl mx-auto py-10">
  <h1 class="text-3xl font-bold text-primary mb-6 text-center">
    My Projects
  </h1>

  <?php if (empty($userProjects)): ?>
    <p class="text-center text-gray-400">You have not submitted any projects yet.</p>
  <?php endif; ?>

  <?php foreach ($userProjects as $p): ?>
    <div class="card bg-base-100 shadow-lg mb-4 border">
      <div class="card-body">
        <h2 class="card-title"><?= htmlspecialchars($p['title']) ?></h2>

        <p class="text-sm">
          Status:
          <span class="badge
            <?= $p['status']=='approved'?'badge-success':'' ?>
            <?= $p['status']=='pending'?'badge-warning':'' ?>
            <?= $p['status']=='rejected'?'badge-error':'' ?>
            <?= $p['status']=='rework'?'badge-info':'' ?>">
            <?= $p['status'] ?>
          </span>
        </p>

        <div class="card-actions justify-end">
          <a class="btn btn-sm btn-outline"
             href="project.php?id=<?= $p['id'] ?>">
             View
          </a>

          <?php if ($p['status']=='rework'): ?>
            <a class="btn btn-sm btn-primary"
               href="submit_project.php?id=<?= $p['id'] ?>">
               Edit & Resubmit
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>
