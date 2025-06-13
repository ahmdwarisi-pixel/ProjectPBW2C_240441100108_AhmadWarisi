<?php
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Tambah ke keranjang
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Tambah/kurangi jumlah item
  if (isset($_POST['ubah_jumlah']) && isset($_POST['keranjang_id']) && isset($_POST['aksi'])) {
    $keranjang_id = (int)$_POST['keranjang_id'];
    $aksi = $_POST['aksi'];

    if ($aksi === 'tambah') {
      mysqli_query($koneksi, "UPDATE keranjang SET jumlah = jumlah + 1 WHERE id = $keranjang_id AND user_id = $user_id");
    } elseif ($aksi === 'kurang') {
      mysqli_query($koneksi, "UPDATE keranjang SET jumlah = jumlah - 1 WHERE id = $keranjang_id AND user_id = $user_id AND jumlah > 1");
    }

    header("Location: keranjang.php");
    exit;
  }

  // Checkout produk yang ditandai
  if (isset($_POST['keranjang_id'])) {
    $ids = $_POST['keranjang_id'];
    $id_list = implode(",", array_map('intval', $ids));
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id IN ($id_list)");
    echo "<script>alert('Produk berhasil di-checkout!'); window.location.href='keranjang.php';</script>";
    exit;
  }
}

// Hapus item satuan
if (isset($_GET['hapus'])) {
  $hapus_id = (int) $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM keranjang WHERE id = $hapus_id AND user_id = $user_id");
  header("Location: keranjang.php");
  exit;
}

// Ambil data keranjang
$data = mysqli_query($koneksi, "
  SELECT k.id, p.nama, p.gambar, k.deskripsi, k.jumlah
  FROM keranjang k
  JOIN produk p ON p.id = k.produk_id
  WHERE k.user_id = $user_id
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <nav class="bg-green-600 text-white shadow-md mb-8">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <h1 class="font-bold text-xl">Toko Online</h1>
      </div>
      <a href="index.php" class="text-sm hover:text-yellow-500">Kembali ke Katalog</a>
    </div>
  </nav>

  <main class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Keranjang Anda</h1>

    <?php if (mysqli_num_rows($data) === 0): ?>
      <p class="mt-6 text-gray-500">Keranjang Anda kosong.</p>
    <?php else: ?>
      <form method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          <?php while ($item = mysqli_fetch_assoc($data)): ?>
            <div class="flex bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300">
              <input type="checkbox" name="keranjang_id[]" value="<?= $item['id'] ?>" class="m-4 mt-6 accent-green-600">
              <img src="<?= $item['gambar'] ?>" class="w-24 h-24 object-cover m-4 rounded-md" onerror="this.src='img/default.jpg';">
              <div class="flex-1 px-2 py-4">
                <h2 class="text-lg font-semibold group-hover:text-green-600"><?= $item['nama'] ?></h2>
                <p class="text-sm text-gray-600 mt-1"><?= $item['deskripsi'] ?></p>
                <p class="text-sm text-gray-500 mb-2">Jumlah: <?= $item['jumlah'] ?></p>

                <div class="flex gap-2 mb-2">
                  <!-- Tambah -->
                  <form method="POST" action="keranjang.php">
                    <input type="hidden" name="keranjang_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="aksi" value="tambah">
                    <button type="submit" name="ubah_jumlah" class="text-white bg-yellow-500 hover:bg-green-600 px-1 py-1 rounded">+</button>
                  </form>

                  <!-- Kurang -->
                  <form method="POST" action="keranjang.php">
                    <input type="hidden" name="keranjang_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="aksi" value="kurang">
                    <button type="submit" name="ubah_jumlah" class="text-white bg-yellow-500 hover:bg-red-600 px-1.5 py-1 rounded">-</button>
                  </form>
                </div>

                <a href="keranjang.php?hapus=<?= $item['id'] ?>" class="text-stone-50 text-sm bg-red-600 px-1 py-1 hover:bg-yellow-500 rounded" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</a>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <button type="submit" class="mt-8 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition">
          Checkout Produk yang Dipilih
        </button>
      </form>
    <?php endif; ?>
  </main>

</body>
</html>
