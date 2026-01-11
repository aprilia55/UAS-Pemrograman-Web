<?php
session_start();
include "../../config/database.php";

// 🔐 hanya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /lets_cook/dashboard/index.php");
    exit;
}

// ambil data ringkasan
$totalRecipes = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM recipes"));
$totalUsers   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Let's Cook</title>

<style>
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin: 0;
    display: flex;
    background: #fafafa;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #ffffff;
    border-right: 1px solid #ddd;
    padding: 20px;
    position: fixed;
}

.sidebar h2 {
    color: #ff6f00;
    text-align: center;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    text-decoration: none;
    color: #333;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    font-weight: bold;
}

.sidebar a:hover {
    background: #ffe0b2;
}

/* CONTENT */
.content {
    margin-left: 240px;
    padding: 40px;
    width: calc(100% - 240px);
}

/* HEADER */
.header {
    margin-bottom: 40px;
}

.header h1 {
    margin: 0;
    color: #ff6f00;
}

/* STATS */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 6px 15px rgba(0,0,0,.15);
}

.card h3 {
    margin: 0;
    color: #555;
}

.card p {
    font-size: 32px;
    margin: 10px 0 0;
    color: #ff6f00;
    font-weight: bold;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🍳 Admin</h2>

    <a href="index.php">🏠 Dashboard</a>
    <a href="recipes.php">📖 Kelola Resep</a>
    <a href="../index.php">👀 Lihat Dashboard User</a>
    <a href="/lets_cook/auth/logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <div class="header">
        <h1>Halo, <?= htmlspecialchars($_SESSION['username']); ?> 👋</h1>
        <p>Ini halaman admin Let’s Cook</p>
    </div>

    <div class="stats">
        <div class="card">
            <h3>Total Resep</h3>
            <p><?= $totalRecipes; ?></p>
        </div>

        <div class="card">
            <h3>Total User</h3>
            <p><?= $totalUsers; ?></p>
        </div>
    </div>

</div>

</body>
</html>
