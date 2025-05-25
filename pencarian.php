<?php
include "koneksi.php";

$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$result = [];

if ($keyword !== '') {
  $query = "SELECT * FROM kost WHERE 
            nama LIKE '%$keyword%' OR 
            lokasi LIKE '%$keyword%' OR 
            deskripsi LIKE '%$keyword%'";
  $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian: <?= htmlspecialchars($keyword) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">🔍 Hasil Pencarian untuk: <span class="text-blue-600"><?= htmlspecialchars($keyword) ?></span></h1>

    <?php if ($keyword === ''): ?>
      <p class="text-gray-500">Silakan masukkan kata kunci pencarian.</p>

    <?php elseif (mysqli_num_rows($result) > 0): ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="bg-white rounded shadow p-4">
            <img src="uploads/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>" class="w-full h-48 object-cover rounded mb-2">
            <h3 class="text-lg font-bold"><?= htmlspecialchars($row['nama']) ?></h3>
            <p class="text-sm text-gray-600"><?= htmlspecialchars($row['lokasi']) ?></p>
            <p class="text-gray-800 mt-1"><?= number_format($row['harga']) ?> /bulan</p>
            <p class="text-sm mt-2"><?= substr(htmlspecialchars($row['deskripsi']), 0, 100) ?>...</p>
          </div>
        <?php endwhile; ?>
      </div>

    <?php else: ?>
      <p class="text-center text-gray-500">Tidak ditemukan kos yang cocok dengan kata "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
    <?php endif; ?>

    <div class="mt-8">
      <a href="index.php" class="text-blue-600 hover:underline">⬅ Kembali ke beranda</a>
    </div>
  </div>
</body>
</html>
