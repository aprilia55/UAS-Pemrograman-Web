<?php
session_start();
include "../../config/database.php";

// 🔐 proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// validasi id
if (!isset($_GET['id'])) {
    header("Location: recipes.php");
    exit;
}

$id = $_GET['id'];

// ambil data gambar
$data = mysqli_query($conn, "SELECT image FROM recipes WHERE id='$id'");
$recipe = mysqli_fetch_assoc($data);

// hapus gambar dari folder jika ada
if ($recipe && !empty($recipe['image'])) {
    $file = "../../uploads/" . $recipe['image'];
    if (file_exists($file)) {
        unlink($file);
    }
}

// hapus data resep
mysqli_query($conn, "DELETE FROM recipes WHERE id='$id'");

// kembali ke halaman recipes
header("Location: recipes.php");
exit;
