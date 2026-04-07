<?php
require_once "auth.php";
require_admin();
require_once "storage.php";
include "menu.php";

$projects = new Storage(new JsonIO("projects.json"));
$pending = $projects->findAll(['status'=>'pending']);
?>

<div class="max-w-5xl mx-auto py-10">
  <h1 class="text-3xl font-bold text-warning mb-6 text-center">
    Pending Projects
  </h1>

  <?php foreach ($pending as $p): ?>
    <div class="card bg-base-100 shadow-lg mb-4 border-l-4 border-warning">
      <div class="card-body">
        <h2 class="card-title"><?= htmlspecialchars($p['title']) ?></h2>

        <div class="card-actions justify-end gap-2">
          <a class="btn btn-success btn-sm"
             href="process_admin_action.php?id=<?= $p['id'] ?>&a=approve">
             Approve
          </a>

          <a class="btn btn-error btn-sm"
             href="process_admin_action.php?id=<?= $p['id'] ?>&a=reject">
             Reject
          </a>

          <a class="btn btn-info btn-sm"
             href="process_admin_action.php?id=<?= $p['id'] ?>&a=rework">
             Send to rework
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>
