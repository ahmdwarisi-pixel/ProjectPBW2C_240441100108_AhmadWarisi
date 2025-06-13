<?php
include 'koneksi.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

$id = (int) $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
  echo "Produk tidak ditemukan.";
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

  // Gunakan gambar lama secara default
  $gambar = $produk['gambar'];

  // Jika admin upload gambar baru
  if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] == 0) {
    $nama_file = basename($_FILES['gambar_baru']['name']);
    $target_file = "img/" . time() . "_" . $nama_file;

    if (move_uploaded_file($_FILES['gambar_baru']['tmp_name'], $target_file)) {
      $gambar = $target_file;
    }
  }

  mysqli_query($koneksi, "UPDATE produk SET
    nama='$nama',
    deskripsi='$deskripsi',
    harga='$harga',
    harga_asli='$harga_asli',
    rating='$rating',
    lokasi='$lokasi',
    gambar='$gambar',
    stok=$stok
    WHERE id=$id
  ");

  header("Location: admin_index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <nav class="bg-green-600 text-white shadow mb-6">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <h1 class="text-lg font-bold">Dashboard Admin</h1>
      <a href="admin_index.php" class="hover:text-yellow-500">Kembali ke Daftar Produk</a>
    </div>
  </nav>

  <!-- Form Container -->
  <main class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6">
      <h2 class="text-xl font-bold text-green-700 mb-4">Edit Produk</h2>

      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" placeholder="Nama Produk" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

        <textarea name="deskripsi" placeholder="Deskripsi Produk" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea>

        <input type="text" name="harga" value="<?= htmlspecialchars($produk['harga']) ?>" placeholder="Harga" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>

        <input type="text" name="harga_asli" value="<?= htmlspecialchars($produk['harga_asli']) ?>" placeholder="Harga Asli (Coret)" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="text" name="rating" value="<?= htmlspecialchars($produk['rating']) ?>" placeholder="Rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="text" name="lokasi" value="<?= htmlspecialchars($produk['lokasi']) ?>" placeholder="Lokasi & Estimasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

        <input type="number" name="stok" value="<?= $produk['stok'] ?>" placeholder="Stok Produk" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm" required>

        <!-- Gambar Lama -->
        <div>
          <p class="text-sm text-gray-600 mb-1">Gambar saat ini:</p>
          <img src="<?= $produk['gambar'] ?>" class="w-32 h-32 object-cover rounded-lg border shadow-sm" onerror="this.src='img/default.jpg';">
        </div>

        <!-- Upload Gambar Baru -->
        <input type="file" name="gambar_baru" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">

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
