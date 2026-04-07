<?php
require_once "auth.php";
require_login();
require_once "storage.php";
include "menu.php";

$projects = new Storage(new JsonIO("projects.json"));

$editProject = null;
if (isset($_GET['id'])) {
  $editProject = $projects->findById($_GET['id']);

  if (!$editProject || $editProject['owner'] !== $_SESSION['user']['username']) {
    header("Location: index.php");
    exit;
  }
}
?>

<div class="max-w-xl mx-auto py-10">
  <div class="card bg-base-100 shadow-xl border">
    <div class="card-body">
      <h2 class="card-title text-primary">
        <?= $editProject ? 'Edit project (rework)' : 'Submit new project' ?>
      </h2>

      <form method="post" action="process_project.php" class="space-y-3">
        <?php if ($editProject): ?>
          <input type="hidden" name="id" value="<?= $editProject['id'] ?>">
        <?php endif; ?>

        <input class="input input-bordered w-full" name="title"
               value="<?= $editProject['title'] ?? '' ?>" placeholder="Title" required>

        <textarea class="textarea textarea-bordered w-full" name="description"
                  placeholder="Description" required><?= $editProject['description'] ?? '' ?></textarea>

        <select class="select select-bordered w-full" name="category">
          <?php
          $cats = [
            "Local small project",
            "Local large project",
            "Equal opportunity Budapest",
            "Green Budapest"
          ];
          foreach ($cats as $c):
          ?>
            <option <?= ($editProject && $editProject['category']==$c)?'selected':'' ?>>
              <?= $c ?>
            </option>
          <?php endforeach; ?>
        </select>

        <input class="input input-bordered w-full" name="postal"
               value="<?= $editProject['postal'] ?? '' ?>" placeholder="Postal code" required>

        <input class="input input-bordered w-full" name="image"
               value="<?= $editProject['image'] ?? '' ?>" placeholder="Image URL">

        <button class="btn btn-primary w-full">
          <?= $editProject ? 'Resubmit' : 'Submit' ?>
        </button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
