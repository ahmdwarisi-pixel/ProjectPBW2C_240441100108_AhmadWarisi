<?php
include 'koneksi.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama       = $_POST['nama'];
  $deskripsi  = $_POST['deskripsi'];
  $harga      = $_POST['harga'];
  $harga_asli = $_POST['harga_asli'];
  $rating     = $_POST['rating'];
  $lokasi     = $_POST['lokasi'];
  $stok       = (int) $_POST['stok'];

  // Upload gambar
  $gambar_path = '';
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $nama_file = basename($_FILES['gambar']['name']);
    $target_dir = "img/";
    $target_file = $target_dir . time() . "_" . $nama_file;

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
      $gambar_path = $target_file;
    }
  }

  mysqli_query($koneksi, "INSERT INTO produk 
    (nama, deskripsi, harga, harga_asli, rating, lokasi, gambar, stok) 
    VALUES 
    ('$nama', '$deskripsi', '$harga', '$harga_asli', '$rating', '$lokasi', '$gambar_path', $stok)
  ");

  header("Location: admin_index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <nav class="bg-green-600 text-white shadow mb-6">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <h1 class="text-lg font-bold">Dashboard Admin</h1>
      <a href="admin_index.php" class="hover:text-yellow-500 text-sm">Kembali ke Daftar Produk</a>
    </div>
  </nav>

  <!-- Form Container -->
  <main class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6">
      <h2 class="text-xl font-bold text-green-700 mb-4">Tambah Produk Baru</h2>

      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="nama" placeholder="Nama Produk" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

        <textarea name="deskripsi" placeholder="Deskripsi Produk" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required></textarea>

        <input type="text" name="harga" placeholder="Harga" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

        <input type="text" name="harga_asli" placeholder="Harga Asli (Coret)" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="text" name="rating" placeholder="Rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="text" name="lokasi" placeholder="Lokasi & Estimasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="number" name="stok" placeholder="Stok Produk" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm" required>

        <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm" required>

        <div class="flex justify-end gap-3 pt-4">
          <a href="admin_index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold shadow transition-all">
            Batal
          </a>
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition-all">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </main>

</body>
</html>
