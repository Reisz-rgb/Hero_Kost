<?php
session_start();
include "koneksi.php";

// Cek role pemilik
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pemilik') {
    header("Location: login_pemilik.php");
    exit;
}

$username = $_SESSION['username'];
$userData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username='$username'"));

$username = $_SESSION['username'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($data);

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
    <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>
    <form action="update_profil_pencari.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-6 max-w-3xl">

      <div>
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block mb-1 font-medium">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full border p-2 rounded">
      </div>

      <div class="col-span-2">
        <label class="block mb-1 font-medium">Ganti Foto Profil</label>
        <input type="file" name="foto" accept="image/*" class="border p-2 w-full rounded">
      </div>

      <div class="col-span-2">
        <label class="block mb-1 font-medium">Password Baru</label>
        <input type="password" name="password" class="w-full border p-2 rounded">
      </div>

      <div class="col-span-2 flex justify-end gap-3">
        <a href="index.php" class="px-4 py-2 border border-gray-400 rounded hover:bg-gray-200">Cancel</a>
        <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Save</button>
      </div>
    </form>
  </main>


</body>
</html>
