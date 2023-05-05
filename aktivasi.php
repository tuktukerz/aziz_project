<?php
    include 'config/config.php';

    session_start();
 

    if (isset($_POST['submit'])) {
        // Ambil nomor telepon dari parameter
        $no_telpn = $_GET["no_telpn"];
    
        // Cek apakah kode OTP disediakan
        if (empty($_POST['otp'])) {
            $error = "Kode OTP tidak boleh kosong";
        } else {
            $otp = $_POST['otp'];
    
            // Query untuk mencari user dengan nomor telepon dan kode OTP yang sesuai
            $sql = "SELECT * FROM users WHERE otp='$otp' AND no_telpn='$no_telpn'";
            $result = mysqli_query($conn, $sql);
    
            if ($result->num_rows > 0) {
                // Jika user ditemukan, ubah nilai is_active menjadi 1
                $row = mysqli_fetch_assoc($result);
                $sql_update = "UPDATE users SET is_active=1 WHERE id={$row['id']}";
                if ($conn->query($sql_update) === false) {
                    die("Error: " . $sql_update . "<br>" . $conn->error);
                }
                // Tampilkan pesan sukses
                $success = "Akun berhasil diaktifkan!";
            } else {
                // Jika user tidak ditemukan, tampilkan pesan error
                $error = "Kode OTP salah atau nomor telepon tidak sesuai!";
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
        <title>Verification Account</title>
    </head>
<body>
  
<div class="relative py-16">
  <div class="container relative m-auto px-6 text-gray-500 md:px-12 xl:px-40">
    <div class="m-auto space-y-8 md:w-8/12 lg:w-6/12 xl:w-6/12">
      <img src="image/logo.png" loading="lazy" class="ml-4 w-36" alt="tailus logo" />
      <div class="rounded-3xl border border-gray-100 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-2xl shadow-gray-600/10 backdrop-blur-2xl">
        <div class="p-8 py-12 sm:p-16">
          <h2 class="mb-8 text-2xl font-bold text-gray-800 dark:text-white">Activation account</h2>
            <?php if (!empty($success)) { ?>
              <div class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>
                    <span class="font-medium"><?= $success ?></span> 
                  </div>
              </div>
            <?php } ?>
            <?php if (!empty($error)) { ?>
              <div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>
                    <span class="font-medium"><?= $error ?>!</span> 
                  </div>
              </div>
            <?php } ?>
            <form action="" method="POST" class="space-y-8">        
              <div class="space-y-2">
                <label for="otp" class="text-gray-600 dark:text-gray-300">Kode OTP</label>
                <input
                  type="text"
                  name="otp"
                  id="otp"
                  autocomplete="code"
                  class="focus:outline-none block w-full rounded-md border border-gray-200 dark:border-gray-600 bg-transparent px-4 py-3 text-gray-600 transition duration-300 invalid:ring-2 invalid:ring-red-400 focus:ring-2 focus:ring-cyan-300"
                  required
                  />
              </div>
              <button name="submit"
              class="w-full rounded-md bg-sky-500 dark:bg-sky-400 h-11 flex items-center justify-center px-6 py-3 transition hover:bg-sky-600 focus:bg-sky-600 active:bg-sky-800">
                  <span class="text-base font-semibold text-white dark:text-gray-900">Aktivasi</span>
              </button>

              <p class="border-t border-gray-100 dark:border-gray-700 pt-6 text-sm text-gray-500 dark:text-gray-400">
                Tidak mempunyai akun ?
                <a href="register.php" class="text-black">Register</a>
              </p>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Lupa code ?
                <a href="find_code.php" class="text-black">Find Code</a>
              </p>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>