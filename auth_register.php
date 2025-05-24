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

// Cek username sudah ada?
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check) > 0) {
    die("Username sudah digunakan.");
}

// Simpan ke database
$query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed', '$role')";
if (mysqli_query($conn, $query)) {
    echo "Register berhasil. <a href='login_pencari.php'>Login di sini</a>";
} else {
    echo "Gagal registrasi: " . mysqli_error($conn);
}
?>
