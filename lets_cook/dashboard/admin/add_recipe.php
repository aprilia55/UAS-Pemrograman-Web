<?php 
session_start();
include "../../config/database.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /lets_cook/dashboard/index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    if ($image != "") {
        move_uploaded_file($tmp, "../uploads/" . $image);
    }

    mysqli_query($conn, "
        INSERT INTO recipes (title, category, ingredients, steps, image)
        VALUES ('$title','$category','$ingredients','$steps','$image')
    ");

    header("Location: recipes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Resep - Let's Cook</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#fafafa;
}
.container{
    max-width:700px;
    margin:40px auto;
}
.card{
    background:white;
    padding:30px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}
h2{
    text-align:center;
    color:#ff6f00;
    margin-bottom:25px;
}
label{
    font-weight:bold;
    margin-top:15px;
    display:block;
}
input, textarea, select{
    width:100%;
    padding:12px;
    margin-top:6px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}
textarea{
    resize:vertical;
}
button{
    width:100%;
    margin-top:25px;
    padding:14px;
    border:none;
    border-radius:14px;
    background:#ff6f00;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}
button:hover{
    background:#e65100;
}
.back{
    text-align:center;
    margin-top:20px;
}
.back a{
    text-decoration:none;
    color:#ff6f00;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="container">
<div class="card">

<h2>➕ Tambah Resep Baru</h2>

<form method="post" enctype="multipart/form-data">

<label>Judul Resep</label>
<input type="text" name="title" required>

<label>Kategori</label>
<select name="category" required>
    <option value="">-- Pilih Kategori --</option>
    <option value="Makanan">Makanan</option>
    <option value="Minuman">Minuman</option>
    <option value="Dessert">Dessert</option>
</select>

<label>Bahan-bahan (1 baris 1 bahan)</label>
<textarea name="ingredients" rows="5" required></textarea>

<label>Langkah-langkah</label>
<textarea name="steps" rows="5" required></textarea>

<label>Foto Resep</label>
<input type="file" name="image">

<button type="submit" name="simpan">💾 Simpan Resep</button>
</form>

<div class="back">
    <a href="recipes.php">⬅ Kembali ke Data Resep</a>
</div>

</div>
</div>

</body>
</html>
