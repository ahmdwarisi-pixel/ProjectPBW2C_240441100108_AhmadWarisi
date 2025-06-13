<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'] ?? 0;
$produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id"));

if (!$produk || $produk['stok'] <= 0) {
  echo "Stok habis atau produk tidak tersedia. <a href='index.php'>Kembali</a>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - <?= htmlspecialchars($produk['nama']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-10">
    <div class="mb-4">
      <a href="index.php" class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold transition-all duration-200">
      Kembali ke Toko
      </a>
    </div>

    <div class="bg-white shadow-lg rounded-2xl p-6 max-w-xl mx-auto">
      <img src="<?= $produk['gambar'] ?>" class="w-full h-60 object-cover rounded-xl mb-4 border border-gray-200" onerror="this.src='img/default.jpg';">
      
      <h1 class="text-2xl font-bold text-green-600 mb-1"><?= htmlspecialchars($produk['nama']) ?></h1>

      <div class="mb-2">
        <span class="text-lg text-green-700 font-bold">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></span>
        <?php if ($produk['harga_asli'] > $produk['harga']): ?>
          <span class="text-sm line-through text-gray-400 ml-2">Rp<?= number_format($produk['harga_asli'], 0, ',', '.') ?></span>
        <?php endif; ?>
      </div>

      <p class="text-yellow-500 text-sm mb-1">⭐ <?= $produk['rating'] ?></p>
      <p class="text-sm text-gray-500 mb-1">📍 <?= $produk['lokasi'] ?></p>
      <p class="text-sm text-green-600 font-medium mb-6">Stok tersedia: <?= $produk['stok'] ?></p>
      <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($produk['deskripsi']) ?></p>

      <form method="POST" action="keranjang.php" class="mb-3">
        <input type="hidden" name="produk_id" value="<?= $produk['id'] ?>">
        <input type="hidden" name="deskripsi" value="<?= htmlspecialchars($produk['deskripsi']) ?>">
        <button type="submit" name="add_to_cart" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-semibold transition-all duration-200">
          Masukkan ke Keranjang
        </button>
      </form>

      <form method="POST" action="checkout_final.php">
        <input type="hidden" name="produk_id" value="<?= $produk['id'] ?>">
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition-all duration-200">
          Checkout Sekarang
        </button>
      </form>
    </div>
  </div>
</body>
</html>
