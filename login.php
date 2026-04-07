<?php include "menu.php"; ?>

<div class="min-h-[80vh] flex items-center justify-center">
  <div class="card w-full max-w-md bg-base-100 shadow-2xl border border-base-300">
    <div class="card-body">

      <h2 class="card-title text-2xl text-primary justify-center">
        Welcome back
      </h2>

      <p class="text-center text-sm text-gray-400 mb-4">
        Login to vote and submit projects
      </p>

      <form method="post" action="process_login.php" class="space-y-4">
        <input
          class="input input-bordered w-full"
          name="username"
          placeholder="Username"
          required
        >

        <input
          class="input input-bordered w-full"
          type="password"
          name="password"
          placeholder="Password"
          required
        >

        <button class="btn btn-primary w-full">
          Login
        </button>
      </form>

      <div class="divider"></div>

      <p class="text-center text-sm">
        Don’t have an account?
        <a href="register.php" class="link link-primary">
          Register here
        </a>
      </p>

    </div>
  </div>
</div>

</body>
</html>
