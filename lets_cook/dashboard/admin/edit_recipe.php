<?php
session_start();
include "../../config/database.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /lets_cook/dashboard/index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$id'");
$recipe = mysqli_fetch_assoc($data);

if (!$recipe) {
    echo "Resep tidak ditemukan 😢";
    exit;
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    if ($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $image);
    } else {
        $image = $recipe['image'];
    }

    mysqli_query($conn, "
        UPDATE recipes SET
        title='$title',
        category='$category',
        ingredients='$ingredients',
        steps='$steps',
        image='$image'
        WHERE id='$id'
    ");

    header("Location: recipes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Resep - Let's Cook</title>

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
}
img{
    width:100%;
    max-height:250px;
    object-fit:cover;
    border-radius:14px;
    margin:10px 0;
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

<h2>✏️ Edit Resep</h2>

<form method="post" enctype="multipart/form-data">

<label>Judul Resep</label>
<input type="text" name="title" value="<?= $recipe['title']; ?>" required>

<label>Kategori</label>
<select name="category">
    <option value="Makanan" <?= $recipe['category']=='Makanan'?'selected':'' ?>>Makanan</option>
    <option value="Minuman" <?= $recipe['category']=='Minuman'?'selected':'' ?>>Minuman</option>
    <option value="Dessert" <?= $recipe['category']=='Dessert'?'selected':'' ?>>Dessert</option>
</select>

<label>Bahan-bahan</label>
<textarea name="ingredients" rows="5"><?= $recipe['ingredients']; ?></textarea>

<label>Langkah-langkah</label>
<textarea name="steps" rows="5"><?= $recipe['steps']; ?></textarea>

<label>Foto Saat Ini</label>
<?php if ($recipe['image']) : ?>
<img src="../uploads/<?= $recipe['image']; ?>">
<?php endif; ?>

<label>Ganti Foto (opsional)</label>
<input type="file" name="image">

<button type="submit" name="update">💾 Update Resep</button>
</form>

<div class="back">
    <a href="recipes.php">⬅ Kembali ke Data Resep</a>
</div>

</div>
</div>

</body>
</html>
