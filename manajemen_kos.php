<?php
session_start();
include "koneksi.php";

// Cek role pemilik
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pemilik') {
    header("Location: login_pemilik.php");
    exit;
}

$fasilitas = $_POST['fasilitas']; // Sudah dalam bentuk string

$username = $_SESSION['username'];
$userData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username='$username'"));

// Ambil semua kos yang dimiliki
$kostList = mysqli_query($conn, "SELECT * FROM kost WHERE owner = '$username'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pemilik Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-50">

  <!-- Sidebar -->
  <aside class="w-64 bg-orange-100 p-6 space-y-5">
    <a href="index.php" class="text-2xl font-bold flex items-center gap-2">
      <img src="uploads/<?php echo $_SESSION['foto'] ?? 'default.png'; ?>" class="w-8 h-8 rounded-full">
      <span>Kost Hero</span>
    </a>
    <hr>
    <a href="profil_pemilik.php" class="block text-lg text-orange-700 font-semibold">✏️ Edit Profile</a>
    <a href="#" class="block text-lg hover:underline">📊 Riwayat Penjualan</a>
    <a href="manajemen_kos.php" class="block text-lg hover:underline">🏘️ Manajemen Kos</a>
    <a href="logout.php" class="block text-lg text-red-600 hover:underline">🚪 Logout</a>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold mb-6">Manajemen Kos</h1>

    <!-- Form Tambah Kos -->
<form action="tambah_kos.php" method="POST" enctype="multipart/form-data"
      class="bg-white shadow p-6 rounded mb-10">
  <h2 class="text-xl font-semibold mb-4">➕ Tambah Kos Baru</h2>
  <div class="grid grid-cols-2 gap-4">
    <input type="text" name="nama" placeholder="Nama Kos" required class="border p-2 rounded">
    <input type="text" name="lokasi" placeholder="Lokasi" required class="border p-2 rounded">
    <input type="number" name="harga" placeholder="Harga per bulan (Rp)" required class="border p-2 rounded">
    <input type="file" name="foto" accept="image/*" required class="border p-2 rounded">
    
    <!-- Baru: No. Pemilik dan Kamar -->
    <input type="text" name="owner_phone" placeholder="No. Pemilik" required 
           class="border p-2 rounded">
    <input type="number" name="rooms_available" placeholder="Kamar Tersedia" required 
           class="border p-2 rounded">
    
    <!-- Baru: Facilities (multi-select) -->
<div class="relative mb-4">
  <input type="text" id="fasilitasInput" readonly placeholder="Pilih fasilitas" 
         class="w-full col-span-2 p-2 border rounded cursor-pointer bg-white" onclick="toggleDropdown()" />

  <div id="dropdownFasilitas" class="absolute z-10 w-full bg-white border rounded mt-1 hidden max-h-40 overflow-y-auto">
    <label class="block p-2 hover:bg-gray-100">
      <input type="checkbox" value="WiFi" onchange="updateFasilitas()"> WiFi
    </label>
    <label class="block p-2 hover:bg-gray-100">
      <input type="checkbox" value="AC" onchange="updateFasilitas()"> AC
    </label>
    <label class="block p-2 hover:bg-gray-100">
      <input type="checkbox" value="Dapur" onchange="updateFasilitas()"> Dapur
    </label>
    <label class="block p-2 hover:bg-gray-100">
      <input type="checkbox" value="Kamar Mandi Dalam" onchange="updateFasilitas()"> Kamar Mandi Dalam
    </label>
    <label class="block p-2 hover:bg-gray-100">
      <input type="checkbox" value="Parkir" onchange="updateFasilitas()"> Parkir
    </label>
  </div>
</div>

<!-- Field tersembunyi untuk disubmit ke server -->
<input type="hidden" name="fasilitas" id="fasilitasHidden">
    
    <textarea name="deskripsi" placeholder="Deskripsi kos..."
              class="col-span-2 border p-2 rounded"></textarea>
  </div>
  <button type="submit"
          class="mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
    Simpan
  </button>
</form>


    <!-- Daftar Kos -->
    <h2 class="text-xl font-semibold mb-4" id="manajemen">🏘️ Kos yang Anda Tambahkan</h2>
    <div class="grid grid-cols-2 gap-6">
      <?php while ($kost = mysqli_fetch_assoc($kostList)): ?>
        <div class="bg-white shadow p-4 rounded">
          <img src="uploads/<?php echo $kost['foto']; ?>" class="w-full h-40 object-cover rounded mb-3">
          <h3 class="text-lg font-bold"><?php echo $kost['nama']; ?></h3>
          <p><?php echo $kost['lokasi']; ?></p>
          <p class="text-green-600 font-semibold">Rp <?php echo number_format($kost['harga'], 0, ',', '.'); ?></p>
          <p class="text-sm text-gray-600 mt-1"><?php echo $kost['deskripsi']; ?></p>
          <div class="flex justify-between mt-4">
            <a href="edit_kos.php?id=<?php echo $kost['id']; ?>" class="text-blue-600 hover:underline">Edit</a>
            <a href="hapus_kos.php?id=<?php echo $kost['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Hapus kos ini?')">Hapus</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <script>
function toggleDropdown() {
  document.getElementById("dropdownFasilitas").classList.toggle("hidden");
}

function updateFasilitas() {
  const checkboxes = document.querySelectorAll('#dropdownFasilitas input[type="checkbox"]');
  const selected = [];

  checkboxes.forEach(cb => {
    if (cb.checked) selected.push(cb.value);
  });

  document.getElementById('fasilitasInput').value = selected.join(', ');
  document.getElementById('fasilitasHidden').value = selected.join(', ');
}

// Menutup dropdown saat klik di luar elemen
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('dropdownFasilitas');
  const input = document.getElementById('fasilitasInput');
  if (!dropdown.contains(event.target) && event.target !== input) {
    dropdown.classList.add('hidden');
  }
});
</script>

</body>
</html>
