<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['login'])) {
    header("Location: /lets_cook/index.php");
    exit;
}

$user = $_SESSION['username'];

// ambil user_id
$getUser = mysqli_query($conn, "SELECT id FROM users WHERE username='$user'");
$userData = mysqli_fetch_assoc($getUser);
$user_id = $userData['id'];

$query = mysqli_query($conn, "
    SELECT recipes.* FROM favorites
    JOIN recipes ON favorites.recipe_id = recipes.id
    WHERE favorites.user_id = '$user_id'
    ORDER BY favorites.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Favorit - Let's Cook</title>

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
    max-width: 1000px;
    margin: auto;
    padding: 30px;
}

h2 {
    margin-bottom: 25px;
    color: #ff6f00;
}

/* CARD LIST */
.card {
    display: flex;
    gap: 20px;
    background: white;
    border-radius: 16px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,.1);
    transition: transform .2s;
}

.card:hover {
    transform: translateY(-4px);
}

/* IMAGE */
.card img {
    width: 160px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
}

/* CONTENT */
.card-content {
    flex: 1;
}

.card-content h3 {
    margin: 0 0 5px;
    font-size: 20px;
}

.card-content small {
    color: gray;
}

.desc {
    margin-top: 8px;
    color: #555;
    font-size: 14px;
    line-height: 1.5;
}

/* LINK */
.card a {
    text-decoration: none;
    color: inherit;
}
</style>
</head>

<body>

<div class="container">

    <h2>⭐ Resep Favorit Kamu</h2>

    <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>

        <a href="detail_recipe.php?id=<?= $row['id']; ?>">
            <div class="card">

                <img src="../uploads/<?= $row['image'] ?: 'default.jpeg'; ?>">

                <div class="card-content">
                    <h3><?= $row['title']; ?></h3>
                    <small><?= $row['category']; ?></small>

                    <div class="desc">
                        <?= substr(strip_tags($row['ingredients']), 0, 120); ?>...
                    </div>
                </div>

            </div>
        </a>

        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada resep favorit 😢</p>
    <?php endif; ?>

</div>

</body>
</html>
