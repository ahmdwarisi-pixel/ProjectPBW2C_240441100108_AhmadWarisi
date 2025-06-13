<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['produk_id'])) {
  $produk_id = (int) $_POST['produk_id'];

  // Ambil data produk
  $produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $produk_id"));

  if (!$produk || $produk['stok'] <= 0) {
    echo "Stok habis atau produk tidak tersedia. <a href='index.php'>Kembali</a>";
    exit;
  }

  // Kurangi stok
  mysqli_query($koneksi, "UPDATE produk SET stok = stok - 1 WHERE id = $produk_id");
} else {
  echo "Permintaan tidak valid. <a href='index.php'>Kembali</a>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout Sukses</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-bold text-green-600 mb-4">Checkout Berhasil</h1>

    <img src="<?= $produk['gambar'] ?>" class="w-full h-60 object-cover rounded-xl border border-gray-200 mb-4" alt="<?= $produk['nama'] ?>" onerror="this.src='img/default.jpg'">

    <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($produk['nama']) ?></h2>
    <p class="text-sm text-gray-600 mt-2 mb-4"><?= htmlspecialchars($produk['deskripsi']) ?></p>

    <p class="text-lg font-bold text-green-700">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
    <?php if ($produk['harga_asli'] > $produk['harga']): ?>
      <p class="text-sm line-through text-gray-400">Rp<?= number_format($produk['harga_asli'], 0, ',', '.') ?></p>
    <?php endif; ?>

    <p class="mt-2 text-yellow-500 text-sm">⭐ <?= $produk['rating'] ?></p>
    <p class="text-sm text-gray-500">📍 <?= $produk['lokasi'] ?></p>

    <div class="mt-6">
      <p class="text-green-600 font-semibold">Terima kasih! Produk Anda akan segera diproses. 💚</p>
      <a href="index.php" class="inline-block mt-4 px-4 py-2 bg-yellow-500 hover:bg-green-500 text-white text-sm rounded-lg transition-all duration-200">
      Kembali ke Katalog
      </a>
    </div>
  </div>
</body>
</html>
