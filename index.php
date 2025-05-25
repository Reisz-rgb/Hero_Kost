<?php include 'koneksi.php'; 
$kosts = mysqli_query($conn, "SELECT * FROM kost ORDER BY id DESC LIMIT 6");
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kost Hero</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <nav class="flex justify-between items-center bg-green-900 text-white px-6 py-4">
    <h1 class="font-bold text-lg">Kost <span class="text-green-300">Hero</span></h1>

<?php if (isset($_SESSION['username'])): ?>
    <?php if ($_SESSION['role'] == 'pencari'): ?>
        <a href="profil_pencari.php">
    <?php elseif ($_SESSION['role'] == 'pemilik'): ?>
        <a href="profil_pemilik.php">
    <?php endif; ?>
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
        <form method="GET" action="pencarian.php" class="mb-6 flex justify-center">
  <input type="text" name="search" placeholder="Cari berdasarkan nama, lokasi, atau deskripsi"
         class="w-full max-w-md p-2 border rounded-l" required>
  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">Cari</button>
</form>
      </div>
    </div>
  </section>

  <!-- Kost Rekomendasi -->
  <section class="mt-10 px-6">
    <h2 class="text-2xl font-bold text-center mt-10 mb-6 text-green-800">KOST REKOMENDASI</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-10">
  <?php while ($k = mysqli_fetch_assoc($kosts)): ?>
    <div class="bg-white shadow rounded overflow-hidden">
      <a href="detail_kos.php?id=<?= $row['id'] ?>">
      <img src="uploads/<?= $k['foto'] ?>" class="h-40 w-full object-cover">
      <div class="p-4">
        <h3 class="font-semibold text-lg"><?= htmlspecialchars($k['nama']) ?></h3>
        <p class="text-sm text-gray-600"><?= $k['lokasi'] ?></p>
        <p class="text-green-600 font-bold mt-1">Rp <?= number_format($k['harga'], 0, ',', '.') ?></p>
      </div>
      </a>
    </div>
  <?php endwhile; ?>
</div>
  </section>
</body>
</html>
