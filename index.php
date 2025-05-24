<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kost Hero</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <!-- Navbar -->  
  <nav class="flex justify-between items-center bg-green-900 text-white px-6 py-4">
    <h1 class="font-bold text-lg">Kost <span class="text-green-300">Hero</span></h1>

    <?php if (isset($_SESSION['username'])): ?>
      <a href="dashboard_<?php echo $_SESSION['role']; ?>.php">
        <img src="uploads/<?php echo $_SESSION['foto'] ?? 'default.png'; ?>" 
             alt="foto profil" 
             class="w-10 h-10 rounded-full border-2 border-white object-cover"/>
      </a>
    <?php else: ?>
      <a href="login_pencari.php" class="hover:underline">Login</a>
    <?php endif; ?>
  </nav>

  <!-- Hero Section -->
  <section class="relative">
    <img src="assets/img/hero.jpg" class="w-full h-[300px] object-cover brightness-75" />
    <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-white">
      <h1 class="text-2xl md:text-4xl font-bold text-center">Platform Cari Kost Paling<br>Simple dan Praktis</h1>
      <div class="mt-4 w-4/5 max-w-xl">
        <div class="flex items-center bg-white rounded shadow px-4 py-2">
          <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a6 6 0 016 6c0 3.314-6 10-6 10S4 11.314 4 8a6 6 0 016-6z"/>
          </svg>
          <input type="text" placeholder="Ketik di sini..." class="ml-2 w-full outline-none text-gray-800" />
        </div>
      </div>
    </div>
  </section>

  <!-- Kost Rekomendasi -->
  <section class="mt-10 px-6">
    <h2 class="text-2xl font-bold text-center text-green-900 mb-6">KOST REKOMENDASI</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
      <?php
      $query = "SELECT * FROM kost LIMIT 3";
      $result = $conn->query($query);
      while ($row = $result->fetch_assoc()) {
      ?>
        <div class="bg-white rounded-xl shadow p-4">
          <img src="assets/img/<?= $row['gambar'] ?>" class="w-full h-40 object-cover rounded-md" />
          <h3 class="mt-3 font-semibold text-gray-800"><?= $row['nama'] ?></h3>
          <p class="text-sm text-gray-600"><?= $row['lokasi'] ?></p>
          <p class="text-yellow-500 text-sm">⭐ <?= $row['rating'] ?></p>
          <p class="mt-1 font-semibold text-green-800">Rp <?= number_format($row['harga'], 0, ',', '.') ?> /bulan</p>
        </div>
      <?php } ?>
    </div>
  </section>
</body>
</html>
