<?php
session_start();
include "koneksi.php";

if ($_SESSION['role'] !== 'pemilik') die("Akses ditolak.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas']; 
    $nomor_pemilik = $_POST['nomor_pemilik'];
    
    // Handle kamar_tersedia - konversi ke integer, default 0 jika kosong
    $kamar_tersedia = isset($_POST['kamar_tersedia']) ? (int)$_POST['kamar_tersedia'] : 0;

    $foto = '';
    if ($_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/$foto");
    }

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("INSERT INTO kost (nama, lokasi, harga, deskripsi, fasilitas, nomor_pemilik, kamar_tersedia, foto, owner) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $nama, $lokasi, $harga, $deskripsi, $fasilitas, $nomor_pemilik, $kamar_tersedia, $foto, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    header("Location: profil_pemilik.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
  <form method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">➕ Tambah Kos</h2>
    
    <input type="text" name="nama" placeholder="Nama Kos" class="w-full mb-2 p-2 border rounded" required>
    <input type="text" name="lokasi" placeholder="Lokasi" class="w-full mb-2 p-2 border rounded" required>
    <input type="number" name="harga" placeholder="Harga per bulan" class="w-full mb-2 p-2 border rounded" required>
    <textarea name="deskripsi" placeholder="Deskripsi kos" class="w-full mb-2 p-2 border rounded" required></textarea>
    
    <label class="block mb-1">Fasilitas:</label>
    <select name="fasilitas[]" multiple class="w-full mb-2 p-2 border rounded">
      <option value="WiFi">WiFi</option>
      <option value="AC">AC</option>
      <option value="Dapur">Dapur</option>
      <option value="Kamar Mandi Dalam">Kamar Mandi Dalam</option>
      <option value="Parkir">Parkir</option>
    </select>

    <input type="text" name="nomor_pemilik" placeholder="Nomor Pemilik (WhatsApp)" class="w-full mb-2 p-2 border rounded" required>
    <input type="number" name="kamar_tersedia" placeholder="Jumlah Kamar Tersedia" class="w-full mb-4 p-2 border rounded" required>

    <label class="block mb-1">Upload Foto:</label>
    <input type="file" name="foto" accept="image/*" class="mb-4">

    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Tambah Kos</button>
  </form>
</body>
</html>
