<?php include "menu.php"; ?>

<div class="min-h-[80vh] flex items-center justify-center">
  <div class="card w-full max-w-md bg-base-100 shadow-2xl border border-base-300">
    <div class="card-body">

      <h2 class="card-title text-2xl text-primary justify-center">
        Create account
      </h2>

      <p class="text-center text-sm text-gray-400 mb-4">
        Register to submit and vote on projects
      </p>

      <form method="post" action="process_register.php" class="space-y-3">
        <input class="input input-bordered w-full" name="username" placeholder="Username" required>
        <input class="input input-bordered w-full" name="email" placeholder="Email" required>
        <input class="input input-bordered w-full" type="password" name="password" placeholder="Password" required>
        <input class="input input-bordered w-full" type="password" name="password2" placeholder="Password again" required>

        <button class="btn btn-primary w-full">
          Register
        </button>
      </form>

      <div class="divider"></div>

      <p class="text-center text-sm">
        Already have an account?
        <a href="login.php" class="link link-primary">
          Login here
        </a>
      </p>

    </div>
  </div>
</div>

</body>
</html>
