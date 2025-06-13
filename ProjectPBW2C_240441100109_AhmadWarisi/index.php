<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE stok > 0 ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Toko Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <nav class="bg-green-600 text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
      <div class="flex items-center space-x-2">
        <h1 class="font-bold text-xl">Toko Online</h1>
      </div>
      <div class="w-full max-w-md">
        <input type="text" placeholder="Cari produk..." class="w-full px-4 py-2 rounded-lg text-sm text-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>
      <div class="flex items-center space-x-6 text-sm">
        <a href="keranjang.php" class="hover:text-yellow-500">Keranjang</a>
        <a href="logout.php" class="hover:text-red-500">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto px-4 mt-10">
    <h1 class="text-2xl font-bold mb-6">Produk Tersedia</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

      <?php foreach ($produk as $p): ?>
        <a href="checkout.php?id=<?= $p['id'] ?>" class="group bg-white rounded-xl shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300 overflow-hidden">
          <img src="<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>" class="w-full h-48 object-cover" onerror="this.src='img/default.jpg';">
          <div class="p-4">
            <h2 class="text-lg font-semibold group-hover:text-green-600"><?= htmlspecialchars($p['nama']) ?></h2>
            <div class="flex items-center space-x-2 mt-1">
              <span class="text-green-600 font-bold text-lg">Rp<?= number_format($p['harga'], 0, ',', '.') ?></span>
              <?php if ($p['harga_asli'] > $p['harga']): ?>
                <span class="text-sm line-through text-gray-400">Rp<?= number_format($p['harga_asli'], 0, ',', '.') ?></span>
              <?php endif; ?>
            </div>
            <div class="mt-2 flex items-center text-yellow-500 text-sm">⭐ <?= htmlspecialchars($p['rating']) ?></div>
            <div class="mt-1 text-xs text-gray-500">Lokasi: <?= htmlspecialchars($p['lokasi']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </main>

</body>
</html>
