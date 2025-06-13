<?php
include 'koneksi.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

$produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");

// Proses hapus jika ada permintaan
if (isset($_GET['hapus'])) {
  $hapus_id = (int) $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM produk WHERE id = $hapus_id");
  header("Location: admin_index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Data Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6 font-sans">

  <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <h1 class="text-2xl font-bold text-green-700">Data Produk</h1>
    <a href="admin_tambah.php" class="bg-green-600 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg transition-all duration-300">
      Tambah Produk
    </a>
  </div>

  <div class="overflow-x-auto shadow rounded-lg bg-white">
    <table class="min-w-full table-auto text-sm text-left">
      <thead class="bg-green-600 text-white uppercase text-xs tracking-wider">
        <tr>
          <th class="px-4 py-3">Gambar</th>
          <th class="px-4 py-3">Nama</th>
          <th class="px-4 py-3">Harga</th>
          <th class="px-4 py-3">Stok</th>
          <th class="px-4 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php while ($p = mysqli_fetch_assoc($produk)): ?>
          <tr class="hover:bg-gray-50 transition-all duration-200">
            <td class="px-4 py-3">
              <img src="<?= $p['gambar'] ?>" class="w-16 h-16 object-cover rounded-lg shadow-sm border border-gray-200" onerror="this.src='img/default.jpg';">
            </td>
            <td class="px-4 py-3 font-medium text-gray-700"><?= htmlspecialchars($p['nama']) ?></td>
            <td class="px-4 py-3 text-green-600 font-semibold">Rp<?= number_format($p['harga'], 0, ',', '.') ?></td>
            <td class="px-4 py-3"><?= $p['stok'] ?></td>
            <td class="px-4 py-3 space-x-2">
              <a href="admin_edit.php?id=<?= $p['id'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md transition-all text-sm">Edit</a>
              <a href="admin_index.php?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus produk ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition-all text-sm">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-6 text-right">
  <a href="admin_logout.php" class="inline-block bg-yellow-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition-all">
    Logout Admin
  </a>
  </div>

</body>
</html>
