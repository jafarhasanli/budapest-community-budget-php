<?php
require_once "storage.php";
require_once "auth.php";
include "menu.php";

$projects=new Storage(new JsonIO("projects.json"));
$p=$projects->findById($_GET['id']);
if(!$p) die("Not found");

$closed = time()-strtotime($p['approved'])>60*60*24*14;
?>

<div class="max-w-xl mx-auto mt-10">
<h1 class="text-2xl"><?= $p['title'] ?></h1>
<p><?= $p['description'] ?></p>
<img src=<?= $p['image'] ?> alt="Photo is bad">

<?php if($closed): ?>
  <p class="text-error">Voting closed</p>
<?php endif; ?>
</div>
