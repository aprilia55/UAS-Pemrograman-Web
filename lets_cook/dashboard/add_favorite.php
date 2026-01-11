<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['login'])) {
    header("Location: /lets_cook/index.php");
    exit;
}

$user_id   = $_SESSION['user_id'];
$recipe_id = $_GET['id'];

// cek apakah sudah favorit
$cek = mysqli_query($conn, "
    SELECT * FROM favorites 
    WHERE user_id='$user_id' AND recipe_id='$recipe_id'
");

if (mysqli_num_rows($cek) == 0) {
    mysqli_query($conn, "
        INSERT INTO favorites (user_id, recipe_id)
        VALUES ('$user_id', '$recipe_id')
    ");
}

// balik ke halaman sebelumnya
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
