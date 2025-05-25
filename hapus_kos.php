<?php
session_start();
include "config.php";

if ($_SESSION['role'] !== 'pemilik') {
    die("Akses ditolak.");
}

$id = $_GET['id'];
$kost = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kost WHERE id=$id AND owner='{$_SESSION['username']}'"));

if ($kost) {
    if ($kost['foto']) unlink("uploads/" . $kost['foto']);
    mysqli_query($conn, "DELETE FROM kost WHERE id=$id");
}

header("Location: profil_pemilik.php");
exit;
?>
