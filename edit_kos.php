<?php
session_start();
include "koneksi.php";

if ($_SESSION['role'] !== 'pemilik') die("Akses ditolak.");

$id = $_GET['id'];
$kost = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kost WHERE id=$id AND owner='{$_SESSION['username']}'"));
if (!$kost) die("Kos tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas']; 
    $nomor_pemilik = $_POST['nomor_pemilik'];
    $kamar_tersedia = $_POST['kamar_tersedia'];

    if ($_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/$foto");
        if ($kost['foto']) unlink("uploads/" . $kost['foto']);
        $foto_sql = ", foto='$foto'";
    } else {
        $foto_sql = '';
    }

    $update = "UPDATE kost SET 
        nama='$nama', lokasi='$lokasi', harga='$harga', deskripsi='$deskripsi',
        fasilitas='$fasilitas', nomor_pemilik='$nomor_pemilik', kamar_tersedia='$kamar_tersedia'
        $foto_sql WHERE id=$id";
        
    mysqli_query($conn, $update);
    header("Location: profil_pemilik.php");
    exit;
}

$selectedFasilitas = explode(', ', $kost['fasilitas']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-50">
  <form action="" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">✏️ Edit Kos</h2>
    <label for="nama" class="block mb-2 font-medium">Nama Kos:</label>
    <input type="text" name="nama" value="<?= $kost['nama'] ?>" class="w-full mb-2 p-2 border rounded" required><br></br>
    
    <label for="lokasi" class="block mb-2 font-medium">Lokasi:</label>
    <input type="text" name="lokasi" value="<?= $kost['lokasi'] ?>" class="w-full mb-2 p-2 border rounded" required><br></br>
    
    <label for="harga" class="block mb-2 font-medium">Harga:</label>
    <input type="number" name="harga" value="<?= $kost['harga'] ?>" class="w-full mb-2 p-2 border rounded" required><br></br>
    
    <label for="deskrpsi" class="block mb-2 font-medium">Deskripsi:</label>
    <textarea name="deskripsi" class="w-full mb-2 p-2 border rounded" required><?= $kost['deskripsi'] ?></textarea><br></br>

    <label for="fasilitas" class="block mb-2 font-medium">Fasilitas:</label>
<div class="relative mb-4">
  <input type="text" id="fasilitasInput" readonly placeholder="Pilih fasilitas" 
         class="w-full p-2 border rounded cursor-pointer bg-white" onclick="toggleDropdown()" />

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

    <label for="nomor" class="block mb-2 font-medium">Nomor Handphone:</label>
    <input type="text" name="nomor_pemilik" value="<?= $kost['nomor_pemilik'] ?>" class="w-full mb-2 p-2 border rounded" required><br></br>
    
    <label for="kamar_tersedia" class="block mb-2 font-medium">Kamar Tersedia:</label>
    <input type="number" name="kamar_tersedia" value="<?= $kost['kamar_tersedia'] ?>" class="w-full mb-4 p-2 border rounded" required><br></br>

    <label class="block mb-1">Ubah Gambar (Opsional):</label>
    <input type="file" name="foto" accept="image/*" class="mb-4">

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
  </form>

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
