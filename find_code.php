<?php
    include 'config/config.php';

    if(isset($_POST['submit'])) {
      
      // Check if code is provided
      if(empty($_POST['email'])) {
        $error = "Email tidak boleh kosong";
      } else {
        $email = $_POST['email'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_assoc($result);

            $successFind = "Kode ditemukan!, Code : {$row['code']}";
        } else {
            $error = "Email $email belum terdaftar";
        }
      } 
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Find Code</title>
    </head>
<body>
  
<div class="relative py-16">
  <div class="container relative m-auto px-6 text-gray-500 md:px-12 xl:px-40">
    <div class="m-auto space-y-8 md:w-8/12 lg:w-6/12 xl:w-6/12">
      <img src="image/logo.png" loading="lazy" class="ml-4 w-36" alt="tailus logo" />
      <div class="rounded-3xl border border-gray-100 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-2xl shadow-gray-600/10 backdrop-blur-2xl">
        <div class="p-8 py-12 sm:p-16">
          <h2 class="mb-8 text-2xl font-bold text-gray-800 dark:text-white">Find Code</h2>
            <?php if (!empty($error)) { ?>
              <div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>
                    <span class="font-medium"><?= $error ?>!</span> 
                  </div>
              </div>
            <?php } ?>
            <?php if (!empty($successFind)) { ?>
              <div class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>
                    <span class="font-medium"><?= $successFind ?></span> 
                  </div>
              </div>
            <?php } ?>
            <form action="" method="POST" class="space-y-8">        
              <div class="space-y-2">
                <label for="username" class="text-gray-600 dark:text-gray-300">Email</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  autocomplete="email"
                  class="focus:outline-none block w-full rounded-md border border-gray-200 dark:border-gray-600 bg-transparent px-4 py-3 text-gray-600 transition duration-300 invalid:ring-2 invalid:ring-red-400 focus:ring-2 focus:ring-cyan-300"
                  required
                  />
              </div>
              <button name="submit"
              class="w-full rounded-md bg-sky-500 dark:bg-sky-400 h-11 flex items-center justify-center px-6 py-3 transition hover:bg-sky-600 focus:bg-sky-600 active:bg-sky-800">
                  <span class="text-base font-semibold text-white dark:text-gray-900">Find Code</span>
              </button>

              <p class="border-t border-gray-100 dark:border-gray-700 pt-6 text-sm text-gray-500 dark:text-gray-400">
                  Punya akun ?
                  <a href="login.php" class="text-black">Login</a>
                </p>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Tidak punya akun ?
                <a href="register.php" class="text-black">Register</a>
              </p>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>