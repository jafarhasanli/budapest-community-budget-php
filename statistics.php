<?php
require_once "auth.php";
require_admin();
require_once "storage.php";
include "menu.php";

$projects = new Storage(new JsonIO("projects.json"));
$votes = new Storage(new JsonIO("votes.json"));

/* STATUS TABLE */
$data = [];
foreach ($projects->findAll() as $p) {
  $data[$p['category']][$p['status']] =
    ($data[$p['category']][$p['status']] ?? 0) + 1;
}

/* MOST VOTED PROJECT */
$topProject = null;
$maxVotes = -1;

foreach ($projects->findAll(['status'=>'approved']) as $p) {
  $count = count($votes->findAll(['project'=>$p['id']]));
  if ($count > $maxVotes) {
    $maxVotes = $count;
    $topProject = $p;
  }
}

/* TOP 3 PER CATEGORY */
$byCategory = [];
foreach ($projects->findAll(['status'=>'approved']) as $p) {
  $p['votes'] = count($votes->findAll(['project'=>$p['id']]));
  $byCategory[$p['category']][] = $p;
}
?>

<div class="max-w-5xl mx-auto py-10">

  <h1 class="text-3xl font-bold text-info mb-6 text-center">
    Project statistics
  </h1>

  <!-- MOST VOTED -->
  <div class="card bg-base-100 shadow mb-8">
    <div class="card-body">
      <h2 class="card-title text-primary">Most voted project</h2>
      <?php if ($topProject): ?>
        <a class="link"
           href="project.php?id=<?= $topProject['id'] ?>">
          <?= $topProject['title'] ?> (<?= $maxVotes ?> votes)
        </a>
      <?php else: ?>
        No votes yet
      <?php endif; ?>
    </div>
  </div>

  <!-- TOP 3 / CATEGORY -->
  <?php foreach ($byCategory as $cat => $list):
    usort($list, fn($a,$b)=>$b['votes'] <=> $a['votes']);
  ?>
    <h3 class="text-xl font-bold mt-6"><?= $cat ?></h3>
    <ul class="list-disc ml-6">
      <?php foreach (array_slice($list,0,3) as $p): ?>
        <li>
          <a href="project.php?id=<?= $p['id'] ?>">
            <?= $p['title'] ?> (<?= $p['votes'] ?> votes)
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endforeach; ?>

  <!-- STATUS TABLE -->
  <div class="overflow-x-auto mt-10">
    <table class="table table-zebra w-full">
      <thead>
        <tr>
          <th>Category</th>
          <th>Pending</th>
          <th>Approved</th>
          <th>Rejected</th>
          <th>Rework</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $cat => $statuses): ?>
          <tr>
            <td><?= $cat ?></td>
            <td><?= $statuses['pending'] ?? 0 ?></td>
            <td><?= $statuses['approved'] ?? 0 ?></td>
            <td><?= $statuses['rejected'] ?? 0 ?></td>
            <td><?= $statuses['rework'] ?? 0 ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
