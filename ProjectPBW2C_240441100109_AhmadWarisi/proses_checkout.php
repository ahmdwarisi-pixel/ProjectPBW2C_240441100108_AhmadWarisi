<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  
  // Simulasi: tampilkan konfirmasi sederhana
  echo "<h2>Terima kasih, $nama!</h2>";
  echo "<p>Pesanan Anda akan dikirim ke: $alamat</p>";
  echo "<a href='index.php'>Kembali ke toko</a>";
} else {
  header("Location: index.php");
  exit;
}
