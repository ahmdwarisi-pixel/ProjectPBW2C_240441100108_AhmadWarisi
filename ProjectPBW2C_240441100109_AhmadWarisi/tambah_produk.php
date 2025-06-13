<?php
include 'koneksi.php';
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama = $_POST['nama'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $harga_asli = $_POST['harga_asli'];
  $rating = $_POST['rating'];
  $lokasi = $_POST['lokasi'];
  $gambar = $_POST['gambar'];

  mysqli_query($koneksi, "INSERT INTO produk (nama, deskripsi, harga, harga_asli, rating, lokasi, gambar)
                          VALUES ('$nama', '$deskripsi', '$harga', '$harga_asli', '$rating', '$lokasi', '$gambar')");
  header("Location: admin_index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">
  <h2 class="text-xl font-bold mb-4">Tambah Produk Baru</h2>
  <form method="POST" class="bg-white p-6 rounded shadow max-w-md">
    <input type="text" name="nama" placeholder="Nama Produk" class="w-full mb-3 px-3 py-2 border rounded" required>
    <textarea name="deskripsi" placeholder="Deskripsi Produk" class="w-full mb-3 px-3 py-2 border rounded" required></textarea>
    <input type="text" name="harga" placeholder="Harga" class="w-full mb-3 px-3 py-2 border rounded" required>
    <input type="text" name="harga_asli" placeholder="Harga Asli" class="w-full mb-3 px-3 py-2 border rounded">
    <input type="text" name="rating" placeholder="Rating" class="w-full mb-3 px-3 py-2 border rounded">
    <input type="text" name="lokasi" placeholder="Lokasi & Estimasi" class="w-full mb-3 px-3 py-2 border rounded">
    <input type="text" name="gambar" placeholder="Path Gambar (contoh: img/canon.jpg)" class="w-full mb-3 px-3 py-2 border rounded">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
  </form>
</body>
</html>
