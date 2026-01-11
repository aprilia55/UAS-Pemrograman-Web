<?php
session_start();
include "../config/database.php";

/* 🔐 WAJIB LOGIN */
if (!isset($_SESSION['login'])) {
    header("Location: /lets_cook/index.php");
    exit;
}

/* 🔎 CEK ID */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$id'");
$recipe = mysqli_fetch_assoc($query);

if (!$recipe) {
    echo "Resep tidak ditemukan 😢";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($recipe['title']); ?> - Let's Cook</title>

<style>
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin: 0;
    background: #fafafa;
}

.container {
    max-width: 1100px;
    margin: auto;
    padding: 30px;
}

/* HEADER */
.header {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    margin-bottom: 40px;
}

.header img {
    width: 100%;
    height: 360px;
    border-radius: 20px;
    object-fit: cover;
}

.title h1 {
    margin-top: 0;
    font-size: 32px;
    color: #ff6f00;
}

.meta {
    color: gray;
    margin-bottom: 15px;
}

.actions {
    margin-top: 20px;
}

.actions a {
    display: inline-block;
    padding: 12px 20px;
    border-radius: 10px;
    background: #ff6f00;
    color: white;
    text-decoration: none;
    font-weight: bold;
}

/* SECTION */
.section {
    background: white;
    padding: 30px;
    border-radius: 20px;
    margin-bottom: 30px;
}

.section h2 {
    margin-top: 0;
    color: #ff6f00;
}

/* LIST */
ul, ol {
    padding-left: 20px;
}

li {
    margin-bottom: 10px;
    line-height: 1.6;
}
</style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <!-- FOTO RESEP (FIXED) -->
        <?php if (!empty($recipe['image'])): ?>
            <img src="/lets_cook/uploads/<?= htmlspecialchars($recipe['image']); ?>">
        <?php else: ?>
            <img src="/lets_cook/uploads/default.jpeg">
        <?php endif; ?>

        <div class="title">
            <h1><?= htmlspecialchars($recipe['title']); ?></h1>
            <div class="meta">
                Kategori: <?= htmlspecialchars($recipe['category']); ?><br>
                Dibuat: <?= date('d M Y', strtotime($recipe['created_at'])); ?>
            </div>

            <div class="actions">
                <a href="add_favorite.php?id=<?= $recipe['id']; ?>">❤️ Simpan Resep</a>
            </div>
        </div>
    </div>

    <!-- BAHAN -->
    <div class="section">
        <h2>🧺 Bahan-bahan</h2>
        <ul>
            <?php
            $ingredients = explode("\n", $recipe['ingredients']);
            foreach ($ingredients as $item) {
                echo "<li>" . htmlspecialchars($item) . "</li>";
            }
            ?>
        </ul>
    </div>

    <!-- LANGKAH -->
    <div class="section">
        <h2>👩‍🍳 Cara Membuat</h2>
        <ol>
            <?php
            $steps = explode("\n", $recipe['steps']);
            foreach ($steps as $step) {
                echo "<li>" . htmlspecialchars($step) . "</li>";
            }
            ?>
        </ol>
    </div>

</div>

</body>
</html>
