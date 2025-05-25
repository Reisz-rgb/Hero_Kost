<?php
include "koneksi.php";

// Validasi input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  http_response_code(400);
  echo "kos tidak ditemukan.";
  exit;
}

$id = intval($_GET['id']);

// Gunakan prepared statement
$query = "SELECT * FROM kost WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (!mysqli_stmt_execute($stmt)) {
  http_response_code(500);
  echo "Terjadi kesalahan dalam pencarian.";
  exit;
}

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
  http_response_code(404);
  echo "Kos tidak ditemukan.";
  exit;
}

$kos = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($kos['nama']) ?> - Detail Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  <div class="container mx-auto px-4 py-8">
    <a href="index.php" class="text-blue-600 hover:underline mb-6 inline-block">⬅ Kembali</a>

    <div class="bg-white rounded shadow p-6">
      <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($kos['nama']) ?></h1>
      <img src="uploads/<?= $kos['foto'] ?>" alt="<?= $kos['nama'] ?>" class="w-full h-64 object-cover rounded mb-4">
      
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <p><strong>Lokasi:</strong> <?= htmlspecialchars($kos['lokasi']) ?></p>
          <p><strong>Harga:</strong> Rp<?= number_format($kos['harga']) ?> / bulan</p>
          <p><strong>Kamar Tersedia:</strong> <?= htmlspecialchars($kos['kamar_tersedia']) ?></p>
          <p><strong>No. Pemilik:</strong> <?= htmlspecialchars($kos['nomor_pemilik']) ?></p>
          <p><strong>Fasilitas:</strong> <?= htmlspecialchars($kos['fasilitas']) ?></p>
        </div>
        <div>
          <p><strong>Deskripsi:</strong></p>
          <p class="mt-2 text-gray-700 whitespace-pre-line"><?= nl2br(htmlspecialchars($kos['deskripsi'])) ?></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
