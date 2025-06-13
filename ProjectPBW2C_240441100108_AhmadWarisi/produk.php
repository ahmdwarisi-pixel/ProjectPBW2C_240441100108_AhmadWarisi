<?php
include 'koneksi.php';

$produk = [];
$query = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($query)) {
  $produk[] = $row;
}
?>
