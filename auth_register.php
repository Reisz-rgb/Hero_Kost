<?php
include "koneksi.php";

$username = $_POST['username'];
$email    = $_POST['email'];
$password = $_POST['password'];
$confirm  = $_POST['confirm'];
$role     = $_POST['role'];

if ($password !== $confirm) {
    die("Password tidak cocok!");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

// Handle Foto
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
}

// Cek username sudah ada?
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check) > 0) {
    die("Username sudah digunakan.");
}

// Simpan ke database
$query = "INSERT INTO users (username, email, password, role, foto) 
          VALUES ('$username', '$email', '$hashed', '$role', '$foto')";

if (mysqli_query($conn, $query)) {
    echo "Register berhasil. <a href='login_pencari.php'>Login</a>";
} else {
    echo "Gagal registrasi: " . mysqli_error($conn);
}
?>
