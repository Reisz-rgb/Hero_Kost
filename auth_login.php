<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['foto'] = $user['foto'];

        if ($user['role'] == 'pencari') {
            header("Location:index.php");
        } else {
            header("Location:index.php");
        }
        exit;
    } else {
        echo "Password salah!";
    }
} else {
    echo "User tidak ditemukan!";
}
?>
