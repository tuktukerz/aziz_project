<?php 

include "../config/config.php";

// Generate Code
$randomInteger = mt_rand(1000000000, 9999999999);

// Convert the integer to a string
$randomString = strval($randomInteger);

// Take the first 10 digits of the string
$code = substr($randomString, 0, 10);

// expired code
$expired_code = date('Y-m-d', strtotime('+6 month'));

// tambah string "PRIME sebelum generate code"
$code = "PRIME" . $code;

// mengambil inputan
$name = $_POST["name"];
$no_telpn = $_POST["no_telpn"];
$email = $_POST["email"];

// isActive = false
$is_active = 0;
// send randomOtp
$otp = rand(100000, 999999);

// Send OTP
$curl = curl_init();
$data = [
    'target' => $no_telpn,
    'message' => "Your OTP : " . $otp
];

curl_setopt(
    $curl,
    CURLOPT_HTTPHEADER,
    array(
        // Insert token without ['']
        "Authorization: ['PASTE TOKEN DISINI']",
    )
);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($curl);
curl_close($curl);

// cek validasi inputan
if (empty($name)) {
    // Jika inputan kosong, kirimkan pesan error ke halaman register.php
    header("Location: ../register.php?error=empty_name");
    exit();
}

if (empty($email)) {
    // Jika inputan kosong, kirimkan pesan error ke halaman register.php
    header("Location: ../register.php?error=empty_email");
    exit();
}

if (empty($no_telpn)) {
    // Jika inputan kosong, kirimkan pesan error ke halaman register.php
    header("Location: ../register.php?error=no_telpn");
    exit();
}

// Check email exists or not
$sqlCheck = "SELECT email FROM users WHERE email='$email'";
$result = $conn->query($sqlCheck);

if ($result->num_rows > 0) {
    // lempar ke halaman register dengan pesan error
    header("Location: ../register.php?error=email_exists");
    exit();
}

$sqlInsert = "INSERT INTO users(name, email, no_telpn, code, expired_code, otp, is_active) 
        VALUES ('$name', '$email', '$no_telpn', '$code', '$expired_code', '$otp', '$is_active')";

if ($conn->query($sqlInsert) === false) {
    die("Error: " . $sqlInsert . "<br>" . $conn->error);
}

?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register Info</title>
</head>


<body >

<!-- component -->
<div class='flex items-center justify-center min-h-screen from-[#3169a9] via-[#3169a9] to-[#3169a9] bg-gradient-to-br px-2'>
    <div class='w-full max-w-md  mx-auto bg-white rounded-3xl shadow-xl overflow-hidden'>
        <div class='max-w-md mx-auto'>
          <div class='p-4 sm:p-6'>
          <div class="max-w-2xl overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Registration Information
                    </h3>
                    <p class="max-w-2xl mt-1 text-sm text-gray-500">
                        Details and informations about user.
                    </p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Name
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?= $name ?>
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?= $email ?>
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                No Telepon
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?= $no_telpn ?>
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Code
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?= $code ?>
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status Akun
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <?php if($is_active == 0):  ?>
                                    Tidak Aktif
                                <?php endif; ?>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>


              <a target='_blank' href='../login.php' class='block mt-10 w-full px-4 py-3 text-white font-medium tracking-wide text-center capitalize transition-colors duration-300 transform bg-[#3169a9] rounded-[14px] hover:bg-[#3169a9] focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80'>
                  Login
              </a>
              <a target='_blank' href="../aktivasi.php?no_telpn=<?php echo $no_telpn; ?>" class='block mt-1.5 w-full px-4 py-3 font-medium tracking-wide text-center capitalize transition-colors duration-300 transform rounded-[14px] hover:bg-[#F2ECE7] hover:text-[#000000dd] focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80'>
                  Aktivasi
              </a>
          </div>
        </div>
    </div>
</div>
</body>
                                    
                                    
</html>