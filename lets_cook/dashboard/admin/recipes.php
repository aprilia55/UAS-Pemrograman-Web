<?php
session_start();
include "../../config/database.php";

// 🔐 KUNCI ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /lets_cook/dashboard/index.php");
    exit;
}

// ambil semua resep
$query = mysqli_query($conn, "SELECT * FROM recipes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Resep - Admin</title>

<style>
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin: 0;
    display: flex;
    background: #fafafa;
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

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header h1 {
    margin: 0;
    color: #ff6f00;
}

.btn {
    background: #ff6f00;
    color: white;
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,.15);
}

th, td {
    padding: 14px;
    text-align: left;
}

th {
    background: #fff3e0;
}

tr:nth-child(even) {
    background: #fafafa;
}

.action a {
    margin-right: 10px;
    text-decoration: none;
    font-weight: bold;
}

.edit { color: #1976d2; }
.delete { color: #d32f2f; }
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
        <h1>Kelola Resep</h1>
        <a href="add_recipe.php" class="btn">➕ Tambah Resep</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['category']); ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                <td class="action">
                    <a href="edit_recipe.php?id=<?= $row['id']; ?>" class="edit">✏ Edit</a>
                    <a href="delete_recipe.php?id=<?= $row['id']; ?>" 
                       class="delete"
                       onclick="return confirm('Yakin hapus resep ini?')">
                       🗑 Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada resep</td>
            </tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>
