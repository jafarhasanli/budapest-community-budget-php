<?php
include "menu.php";
require_once "storage.php";

$projects = new Storage(new JsonIO("projects.json"));
$votes = new Storage(new JsonIO("votes.json"));
$user = $_SESSION['user']['username'] ?? null;

$selectedCategory = $_GET['category'] ?? 'all';

/* Group projects by category */
$grouped = [];
foreach ($projects->findAll(['status'=>'approved']) as $p) {
  if ($selectedCategory !== 'all' && $p['category'] !== $selectedCategory) {
    continue;
  }
  $grouped[$p['category']][] = $p;
}
?>

<div class="max-w-5xl mx-auto py-10">

  <h1 class="text-3xl font-bold text-center text-primary mb-6">
    Approved Projects
  </h1>

  <!-- CATEGORY FILTER -->
  <form method="get" class="flex justify-center mb-8">
    <select name="category"
            class="select select-bordered w-80"
            onchange="this.form.submit()">
      <option value="all">All categories</option>
      <?php
      $cats = [
        "Local small project",
        "Local large project",
        "Equal opportunity Budapest",
        "Green Budapest"
      ];
      foreach ($cats as $c):
      ?>
        <option value="<?= $c ?>"
          <?= $selectedCategory === $c ? 'selected' : '' ?>>
          <?= $c ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <?php foreach ($grouped as $category => $list): ?>
    <h2 class="text-2xl font-bold text-secondary mb-4">
      <?= htmlspecialchars($category) ?>
    </h2>

    <?php foreach ($list as $p): 
      $count = count($votes->findAll(['project'=>$p['id']]));
      $voted = $user ? $votes->findOne(['user'=>$user,'project'=>$p['id']]) : null;
    ?>
      <div class="card bg-base-100 shadow-xl mb-6 border border-base-300">
        <div class="card-body">

          <h3 class="card-title text-xl text-primary">
            <?= htmlspecialchars($p['title']) ?>
          </h3>

          <div class="flex items-center gap-3">
            <span class="badge badge-accent">
              <?= htmlspecialchars($p['category']) ?>
            </span>
            <span class="badge badge-info">
              Votes: <?= $count ?>
            </span>
          </div>

          <div class="card-actions justify-end mt-4 gap-2">
            <?php if ($user): ?>
              <button
                class="btn btn-sm <?= $voted ? 'btn-error' : 'btn-success' ?>"
                onclick="vote('<?= $p['id'] ?>','<?= $voted ? 'remove' : 'add' ?>')">
                <?= $voted ? 'Withdraw vote' : 'Vote' ?>
              </button>
            <?php endif; ?>

            <a class="btn btn-sm btn-outline"
               href="project.php?id=<?= $p['id'] ?>">
              Details
            </a>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>

</div>

<script>
function vote(project, action) {
  fetch('process_vote.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `project=${project}&action=${action}`
  })
  .then(r => r.json())
  .then(d => {
    if (d.error) {
      alert(d.error);
    } else {
      location.reload();
    }
  });
}
</script>

</body>
</html>
