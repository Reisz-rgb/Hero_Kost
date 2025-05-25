<?php
session_start();
include "koneksi.php";

$username = $_SESSION['username'];

$new_name = $_POST['first_name'];
$new_email = $_POST['email'];
$new_pass = $_POST['password'];
$new_foto = $_FILES['foto'];

$update_query = "UPDATE users SET username='$new_name', email='$new_email'";

// Jika password diisi
if (!empty($new_pass)) {
    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
    $update_query .= ", password='$hashed'";
}

// Jika ada foto baru
if (isset($new_foto) && $new_foto['error'] === 0) {
    $ext = pathinfo($new_foto['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    move_uploaded_file($new_foto['tmp_name'], "uploads/$filename");
    $update_query .= ", foto='$filename'";
    $_SESSION['foto'] = $filename;
}

// Lanjut update
$update_query .= " WHERE username='$username'";
if (mysqli_query($conn, $update_query)) {
    $_SESSION['username'] = $new_name;
    header("Location: profil_pencari.php");
} else {
    echo "Gagal update profil: " . mysqli_error($conn);
}
?>
