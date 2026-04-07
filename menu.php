<?php require_once "auth.php"; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dracula">
<head>
  <meta charset="UTF-8">
  <title>Community Budget</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.9.0/dist/full.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-base-200 min-h-screen">

<div class="navbar bg-base-100 shadow-lg px-6">
  <div class="flex-1">
    <a class="text-xl font-bold text-primary" href="index.php">
      Community Budget
    </a>
  </div>

  <div class="flex-none space-x-2">
    <?php if (is_logged_in()): ?>
      <span class="badge badge-secondary badge-lg">
        <?= htmlspecialchars($_SESSION['user']['username']) ?>
      </span>

      <a class="btn btn-sm btn-primary" href="submit_project.php">
        Submit
      </a>

      <a class="btn btn-sm btn-outline" href="projects-own.php">
        My Projects
      </a>

      <?php if (is_admin()): ?>
        <a class="btn btn-sm btn-warning" href="projects-admin.php">
          Admin
        </a>
        <a class="btn btn-sm btn-info" href="statistics.php">
          Stats
        </a>
      <?php endif; ?>

      <a class="btn btn-sm btn-error" href="logout.php">
        Logout
      </a>
    <?php else: ?>
      <a class="btn btn-sm btn-primary" href="login.php">
        Login
      </a>
      <a class="btn btn-sm btn-outline" href="register.php">
        Register
      </a>
    <?php endif; ?>
  </div>
</div>
