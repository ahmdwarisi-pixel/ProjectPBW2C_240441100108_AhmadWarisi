<?php
include 'koneksi.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
  $admin = mysqli_fetch_assoc($result);

  if ($admin && hash('sha256', $password) === $admin['password']) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_user'] = $admin['username'];
    header("Location: admin_index.php");
    exit;
  } else {
    $error = "Username atau password salah.";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center text-gray-800">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold text-center text-green-700 mb-6">Login Admin</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 border border-red-300 text-sm">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="username" placeholder="Username"
             class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

      <input type="password" name="password" placeholder="Password"
             class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

      <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg shadow transition-all">
        Masuk
      </button>
    </form>
  </div>

</body>
</html>

