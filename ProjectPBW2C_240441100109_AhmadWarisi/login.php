<?php
include 'koneksi.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: index.php");
    exit;
  } else {
    $error = "Email atau password salah.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Toko Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-cover bg-center" style="background-image: url('bg/bg login.jpg');">
  <div class="flex items-center justify-center h-full bg-black bg-opacity-60">
    <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-lg w-96">
      <h2 class="text-2xl font-bold text-green-600 mb-6">Login</h2>

      <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 text-sm p-3 rounded-md mb-4 border border-red-300"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required
          class="w-full mb-4 px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none text-sm" />

        <input type="password" name="password" placeholder="Password" required
          class="w-full mb-4 px-4 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none text-sm" />

        <button type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition-all duration-200">
          Login
        </button>

        <p class="mt-6 text-sm text-gray-500 text-center">
          Belum punya akun? <a href="register.php" class="text-green-600 hover:underline">Daftar Sekarang</a>.
        </p>
      </form>
    </div>
  </div>
</body>
</html>
